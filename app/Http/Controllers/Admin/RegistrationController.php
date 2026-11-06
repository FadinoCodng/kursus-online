<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Registration;
use App\Enums\RegistrationStatus;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with('course');

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->paginate(15)->withQueryString();
        $courses = Course::orderBy('title')->get();
        $statuses = RegistrationStatus::cases();

        return view('admin.registrations.index', compact('registrations', 'courses', 'statuses'));
    }

    public function updateStatus(Request $request, Registration $registration)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,diterima,ditolak'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $registration->update([
            'status' => $request->status,
            'notes' => $request->notes ?? $registration->notes,
        ]);

        return redirect()->back()->with('success', 'Status pendaftar berhasil diperbarui!');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()->back()->with('success', 'Data pendaftar berhasil dihapus!');
    }

    // Fitur Bonus: Ekspor data pendaftar ke CSV/Excel
    public function export(Request $request)
    {
        $query = Registration::with('course');

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->get();

        $fileName = 'data-pendaftar-' . date('Y-m-d-His') . '.csv';

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        return new StreamedResponse(function () use ($registrations) {
            $handle = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['No', 'Nama Pendaftar', 'Email', 'No Telepon', 'Kelas', 'Harga Kelas', 'Status', 'Catatan', 'Tanggal Daftar']);

            foreach ($registrations as $index => $item) {
                fputcsv($handle, [
                    $index + 1,
                    $item->name,
                    $item->email,
                    $item->phone,
                    $item->course->title ?? '-',
                    $item->course->formatted_price ?? '-',
                    $item->status->label(),
                    $item->notes ?? '-',
                    $item->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
