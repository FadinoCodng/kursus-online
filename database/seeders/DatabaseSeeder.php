<?php

namespace Database\Seeders;

use App\Enums\CourseStatus;
use App\Enums\RegistrationStatus;
use App\Models\Article;
use App\Models\Category;
use App\Models\Course;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Default
        $admin = User::firstOrCreate(
            ['email' => 'admin@kursusonline.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Kategori Kelas
        $categoriesData = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Pelajari teknologi pengembangan web dari frontend hingga backend modern.',
            ],
            [
                'name' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'description' => 'Membangun aplikasi Android dan iOS menggunakan Flutter & React Native.',
            ],
            [
                'name' => 'Data Science & AI',
                'slug' => 'data-science-ai',
                'description' => 'Kuasai analisis data, machine learning, dan implementasi kecerdasan buatan.',
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'description' => 'Rancang antarmuka produk digital yang estetik, intuitif, dan ramah pengguna.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Kelas (Courses)
        $coursesData = [
            [
                'category_id' => $categories['web-development']->id,
                'title' => 'Mastering Laravel 13 & Modern Web API',
                'slug' => 'mastering-laravel-13-modern-web-api',
                'description' => 'Pelajari arsitektur Laravel 13, pembuatan RESTful API, autentikasi modern, optimasi query Eloquent, dan best practices enterprise.',
                'instructor_name' => 'Budi Pratama, S.Kom, M.T.',
                'price' => 299000,
                'is_free' => false,
                'image' => null,
                'status' => CourseStatus::PUBLISHED,
            ],
            [
                'category_id' => $categories['web-development']->id,
                'title' => 'Fundamental Tailwind CSS 4 & Responsive Design',
                'slug' => 'fundamental-tailwind-css-4',
                'description' => 'Kuasai pembuatan tampilan website responsif, mobile-first, dan interaktif dengan cepat menggunakan Tailwind CSS.',
                'instructor_name' => 'Siti Rahmawati',
                'price' => 0,
                'is_free' => true,
                'image' => null,
                'status' => CourseStatus::PUBLISHED,
            ],
            [
                'category_id' => $categories['mobile-app-development']->id,
                'title' => 'Flutter 3 Multiplatform: Dari Nol Sampai Siap Kerja',
                'slug' => 'flutter-3-multiplatform-nol-sampai-kerja',
                'description' => 'Membangun aplikasi Android & iOS dengan satu basis kode Flutter. Belajar state management Bloc & integrasi REST API.',
                'instructor_name' => 'Andi Wijaya',
                'price' => 350000,
                'is_free' => false,
                'image' => null,
                'status' => CourseStatus::PUBLISHED,
            ],
            [
                'category_id' => $categories['data-science-ai']->id,
                'title' => 'Python untuk Data Science & Machine Learning',
                'slug' => 'python-data-science-machine-learning',
                'description' => 'Mempelajari manipulasi data dengan Pandas, visualisasi Matplotlib/Seaborn, dan pemodelan dasar Scikit-Learn.',
                'instructor_name' => 'Dr. Hendra Saputra',
                'price' => 450000,
                'is_free' => false,
                'image' => null,
                'status' => CourseStatus::PUBLISHED,
            ],
            [
                'category_id' => $categories['ui-ux-design']->id,
                'title' => 'UI/UX Design Essentials dengan Figma',
                'slug' => 'ui-ux-design-essentials-figma',
                'description' => 'Pelajari design system, prototyping interaktif, user journey mapping, dan cara handoff design ke tim developer.',
                'instructor_name' => 'Maya Kartika',
                'price' => 250000,
                'is_free' => false,
                'image' => null,
                'status' => CourseStatus::PUBLISHED,
            ],
            [
                'category_id' => $categories['web-development']->id,
                'title' => 'Workshop Git & GitHub untuk Kolaborasi Tim (Draft)',
                'slug' => 'workshop-git-github-kolaborasi',
                'description' => 'Kelas pengenalan branch, pull request, merge conflict, dan git workflow modern.',
                'instructor_name' => 'Budi Pratama, S.Kom, M.T.',
                'price' => 0,
                'is_free' => true,
                'image' => null,
                'status' => CourseStatus::DRAFT,
            ],
        ];

        $createdCourses = [];
        foreach ($coursesData as $course) {
            $createdCourses[] = Course::firstOrCreate(['slug' => $course['slug']], $course);
        }

        // 4. Data Pendaftar (Registrations)
        $registrationsData = [
            [
                'course_id' => $createdCourses[0]->id,
                'name' => 'Rian Hidayat',
                'email' => 'rian.hidayat@example.com',
                'phone' => '081234567890',
                'status' => RegistrationStatus::DITERIMA,
                'notes' => 'Sudah melakukan verifikasi pembayaran via transfer bank.',
            ],
            [
                'course_id' => $createdCourses[0]->id,
                'name' => 'Dewi Anggraini',
                'email' => 'dewi.anggraini@example.com',
                'phone' => '081298765432',
                'status' => RegistrationStatus::PENDING,
                'notes' => 'Menunggu konfirmasi admin.',
            ],
            [
                'course_id' => $createdCourses[1]->id,
                'name' => 'Fajar Nugraha',
                'email' => 'fajar.nugraha@example.com',
                'phone' => '085712341234',
                'status' => RegistrationStatus::DITERIMA,
                'notes' => 'Kelas gratis, otomatis diterima.',
            ],
            [
                'course_id' => $createdCourses[2]->id,
                'name' => 'Gita Savitri',
                'email' => 'gita.savitri@example.com',
                'phone' => '082155667788',
                'status' => RegistrationStatus::DITOLAK,
                'notes' => 'Bukti pembayaran tidak terbaca / tidak valid.',
            ],
            [
                'course_id' => $createdCourses[3]->id,
                'name' => 'Bambang Irawan',
                'email' => 'bambang.irawan@example.com',
                'phone' => '087811223344',
                'status' => RegistrationStatus::PENDING,
                'notes' => 'Pendaftaran baru masuk.',
            ],
            [
                'course_id' => $createdCourses[4]->id,
                'name' => 'Nadya Fitriani',
                'email' => 'nadya.fitri@example.com',
                'phone' => '089677889900',
                'status' => RegistrationStatus::DITERIMA,
                'notes' => 'Sudah bergabung ke grup WhatsApp kelas.',
            ],
        ];

        foreach ($registrationsData as $reg) {
            Registration::firstOrCreate(
                ['course_id' => $reg['course_id'], 'email' => $reg['email']],
                $reg
            );
        }

        // 5. Artikel Blog Sederhana (Fitur Bonus)
        $articlesData = [
            [
                'title' => 'Panduan Belajar Web Development untuk Pemula di Tahun 2026',
                'slug' => 'panduan-belajar-web-development-pemula-2026',
                'summary' => 'Memulai karir di bidang web development tidak harus membingungkan. Simak roadmap terstruktur dari HTML/CSS hingga framework Laravel.',
                'content' => "<p>Industri teknologi terus berkembang pesat. Bagi Anda yang baru memulai, fokuslah pada tiga pilar utama: dasar pemrograman (HTML, CSS, JavaScript), pemahaman backend (seperti PHP dan Laravel), serta manajemen basis data.</p><p>Di lembaga pelatihan kami, materi disusun secara runtut dan disertai studi kasus nyata dunia kerja agar setiap peserta siap menghadapi dunia industri.</p>",
                'author' => 'Tim Pengajar',
                'is_published' => true,
            ],
            [
                'title' => 'Kenapa Laravel Masih Menjadi Framework PHP Terfavorit?',
                'slug' => 'kenapa-laravel-masih-menjadi-framework-php-terfavorit',
                'summary' => 'Dengan ekosistem yang luar biasa, dokumentasi rapi, dan fitur modern, Laravel tetap mendominasi pasar backend development.',
                'content' => "<p>Laravel menawarkan sintaks yang elegan dan ekspresif. Fitur seperti Eloquent ORM, migrasi database terstruktur, dan ekosistem keamanan bawaan membuat developer dapat membangun aplikasi dalam waktu singkat tanpa mengorbankan kualitas dan keamanan.</p>",
                'author' => 'Budi Pratama',
                'is_published' => true,
            ],
        ];

        foreach ($articlesData as $art) {
            Article::firstOrCreate(['slug' => $art['slug']], $art);
        }
    }
}
