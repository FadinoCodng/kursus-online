<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Registration;
use App\Enums\CourseStatus;
use App\Enums\RegistrationStatus;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCourses = Course::count();
        $publishedCourses = Course::where('status', CourseStatus::PUBLISHED)->count();
        $draftCourses = Course::where('status', CourseStatus::DRAFT)->count();

        $totalRegistrations = Registration::count();
        $pendingRegistrations = Registration::where('status', RegistrationStatus::PENDING)->count();
        $acceptedRegistrations = Registration::where('status', RegistrationStatus::DITERIMA)->count();
        $rejectedRegistrations = Registration::where('status', RegistrationStatus::DITOLAK)->count();

        $totalCategories = Category::count();

        // 5 Pendaftar terbaru sesuai spesifikasi
        $latestRegistrations = Registration::with('course')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCourses',
            'publishedCourses',
            'draftCourses',
            'totalRegistrations',
            'pendingRegistrations',
            'acceptedRegistrations',
            'rejectedRegistrations',
            'totalCategories',
            'latestRegistrations'
        ));
    }
}
