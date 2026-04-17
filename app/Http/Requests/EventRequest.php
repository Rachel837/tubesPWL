<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_event' => 'required|string|max:255',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'location' => 'required|string|max:255',
            'max_participant' => 'required|integer|min:1',
            'status' => 'required|string',
            'koordinator' => 'required|integer|exists:users,id',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|exists:categories,id',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_event.required' => 'Nama event wajib diisi.',
            'date_start.required' => 'Tanggal mulai wajib diisi',
            'date_end.required' => 'Tanggal selesai wajib diisi',
            'date_end.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'location.required' => 'Lokasi wajib diisi.',
            'max_participant.required' => 'Maksimal peserta wajib diisi.',
            'status.required' => 'Status wajib diisi.',
            'koordinator.required' => 'Koordinator wajib diisi.',
            'koordinator.exists' => 'Koordinator tidak ditemukan.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori tidak valid.',
            'banner.image' => 'File harus berupa gambar.',
            'banner.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'banner.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
