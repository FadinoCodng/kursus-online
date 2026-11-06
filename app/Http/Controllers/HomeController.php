<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Course;
use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount(['courses' => function ($q) {
            $q->published();
        }])->get();

        $query = Course::query()->with('category')->published();

        // Search
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('instructor_name', 'like', "%{$search}%");
            });
        }

        // Filter Category
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filter Pricing
        if ($request->filled('pricing')) {
            if ($request->pricing === 'free') {
                $query->where('is_free', true);
            } elseif ($request->pricing === 'paid') {
                $query->where('is_free', false)->where('price', '>', 0);
            }
        }

        $courses = $query->latest()->paginate(6)->withQueryString();

        $articles = Article::where('is_published', true)->latest()->take(3)->get();

        return view('landing.index', compact('categories', 'courses', 'articles'));
    }

    public function showCourse(string $slug)
    {
        $course = Course::with('category')->where('slug', $slug)->firstOrFail();
        
        $relatedCourses = Course::published()
            ->where('id', '!=', $course->id)
            ->where('category_id', $course->category_id)
            ->take(3)
            ->get();

        return view('landing.course-detail', compact('course', 'relatedCourses'));
    }

    public function registerCourse(StoreRegistrationRequest $request)
    {
        $registration = Registration::create([
            'course_id' => $request->course_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Selamat, pendaftaran Anda untuk kelas ini berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }

    public function articles()
    {
        $articles = Article::where('is_published', true)->latest()->paginate(6);
        return view('landing.articles', compact('articles'));
    }

    public function showArticle(string $slug)
    {
        $article = Article::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $recentArticles = Article::where('is_published', true)->where('id', '!=', $article->id)->latest()->take(4)->get();
        return view('landing.article-detail', compact('article', 'recentArticles'));
    }
}
