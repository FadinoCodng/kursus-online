<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $courseId = $this->input('course_id');

        return [
            'course_id' => ['required', 'exists:courses,id'],
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('registrations')->where(function ($query) use ($courseId) {
                    return $query->where('course_id', $courseId);
                }),
            ],
            'phone' => ['required', 'string', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'course_id.required' => 'Kelas harus dipilih.',
            'course_id.exists' => 'Kelas tidak ditemukan.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar pada kelas yang sama. Anda tidak dapat mendaftar dua kali.',
            'phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
        ];
    }
}
