<?php

namespace Tests\Feature;

use App\Enums\CourseStatus;
use App\Enums\RegistrationStatus;
use App\Models\Category;
use App\Models\Course;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Category $category;
    private Course $publishedCourse;
    private Course $draftCourse;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@kursusonline.com',
            'password' => bcrypt('password123'),
        ]);

        $this->category = Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Kategori belajar web',
        ]);

        $this->publishedCourse = Course::create([
            'category_id' => $this->category->id,
            'title' => 'Laravel 13 Masterclass',
            'slug' => 'laravel-13-masterclass',
            'description' => 'Belajar Laravel dari dasar sampai mahir.',
            'instructor_name' => 'Budi Pratama',
            'price' => 250000,
            'is_free' => false,
            'status' => CourseStatus::PUBLISHED,
        ]);

        $this->draftCourse = Course::create([
            'category_id' => $this->category->id,
            'title' => 'Secret Draft Course',
            'slug' => 'secret-draft-course',
            'description' => 'Kelas masih dirancang.',
            'instructor_name' => 'Budi Pratama',
            'price' => 0,
            'is_free' => true,
            'status' => CourseStatus::DRAFT,
        ]);
    }

    /**
     * Test: Landing page menampilkan kelas published dan menyembunyikan kelas draft
     */
    public function test_landing_page_shows_only_published_courses(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Laravel 13 Masterclass');
        $response->assertDontSee('Secret Draft Course');
    }

    /**
     * Test: Pengunjung berhasil mendaftar ke kelas online
     */
    public function test_user_can_register_for_a_course(): void
    {
        $response = $this->post(route('courses.register'), [
            'course_id' => $this->publishedCourse->id,
            'name' => 'Fadino Test',
            'email' => 'fadino@example.com',
            'phone' => '081234567890',
            'notes' => 'Ingin belajar backend',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('registrations', [
            'course_id' => $this->publishedCourse->id,
            'email' => 'fadino@example.com',
            'status' => RegistrationStatus::PENDING->value,
        ]);
    }

    /**
     * Test: Satu email TIDAK boleh mendaftar dua kali di kelas yang sama
     */
    public function test_user_cannot_register_twice_with_same_email_on_same_course(): void
    {
        // Pendaftaran pertama
        Registration::create([
            'course_id' => $this->publishedCourse->id,
            'name' => 'Fadino Test',
            'email' => 'fadino@example.com',
            'phone' => '081234567890',
            'status' => RegistrationStatus::PENDING,
        ]);

        // Coba mendaftar lagi dengan email yang sama di kelas yang sama
        $response = $this->post(route('courses.register'), [
            'course_id' => $this->publishedCourse->id,
            'name' => 'Fadino Test Lagi',
            'email' => 'fadino@example.com',
            'phone' => '081234567899',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertEquals(1, Registration::where('email', 'fadino@example.com')->count());
    }

    /**
     * Test: Admin harus login untuk mengakses dashboard
     */
    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Admin yang sudah login dapat mengakses dashboard & mengubah status pendaftar
     */
    public function test_admin_can_update_registration_status(): void
    {
        $registration = Registration::create([
            'course_id' => $this->publishedCourse->id,
            'name' => 'Peserta Uji',
            'email' => 'peserta@example.com',
            'phone' => '081299999999',
            'status' => RegistrationStatus::PENDING,
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.registrations.update-status', $registration->id), [
                'status' => RegistrationStatus::DITERIMA->value,
            ]);

        $response->assertSessionHas('success');
        $this->assertEquals(RegistrationStatus::DITERIMA, $registration->fresh()->status);
    }
}
