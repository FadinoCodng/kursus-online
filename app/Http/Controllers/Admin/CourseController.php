<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Enums\CourseStatus;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('category')->withCount('registrations');

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('instructor_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $courses = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $statuses = CourseStatus::cases();
        return view('admin.courses.create', compact('categories', 'statuses'));
    }

    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        $data['is_free'] = $request->boolean('is_free');
        if ($data['is_free']) {
            $data['price'] = 0;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        Course::create($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Kelas baru berhasil ditambahkan!');
    }

    public function show(Course $course)
    {
        $course->load(['category', 'registrations']);
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = Category::all();
        $statuses = CourseStatus::cases();
        return view('admin.courses.edit', compact('course', 'categories', 'statuses'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $data = $request->validated();
        $data['is_free'] = $request->boolean('is_free');
        if ($data['is_free']) {
            $data['price'] = 0;
        }

        if ($request->hasFile('image')) {
            if ($course->image && Storage::disk('public')->exists($course->image)) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Informasi kelas berhasil diperbarui!');
    }

    public function destroy(Course $course)
    {
        if ($course->image && Storage::disk('public')->exists($course->image)) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}
