<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $categoryId = $this->route('category') ? $this->route('category')->id : null;

        return [
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'nama_kategori')->ignore($categoryId)
            ],
            'deskripsi' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter',
        ];
    }
}
