<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeadOfFamilyStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'profile_picture' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'identity_number' => 'required|integer',
            'gender' => 'required|string|in:male,female',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string',
            'occupation' => 'required|string',
            'marital_status' => 'required|string|in:single,married',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Kata Sandi',
            'profile_picture' => 'Foto Profil',
            'identity_number' => 'Nomor Identitas',
            'gender' => 'Jenis Kelamin',
            'phone_number' => 'Nomor Telepon',
            'occupation' => 'Pekerjaan',
            'marital_status' => 'Status Perkawinan',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi',
            'string' => ':attribute harus berupa string',
            'max' => ':attribute maksimal :max karakter',
            'unique' => ':attribute sudah ada',
            'image' => ':attribute harus berupa gambar',
            'email' => ':attribute harus berupa email',
            'min' => ':attribute minimal :min karakter',
            'exists' => ':attribute tidak ditemukan',
            'integer' => ':attribute harus berupa angka',
            'array' => ':attribute harus berupa array',
            'mimes' => ':attribute harus berupa gambar',
            'max:2048' => ':attribute maksimal 2048 KB',
            'unique:users' => ':attribute sudah ada',
            'in' => ':attribute harus berupa salah satu dari :values',
            'date' => ':attribute harus berupa tanggal',
        ];
    }
}
