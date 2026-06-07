<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // public function rules(): array
    // {
    //     return [
    //         'name' => ['required', 'string', 'max:255'],

    //         'email' => [
    //             'required',
    //             'string',
    //             'email',
    //             'max:255',
    //             Rule::unique(User::class)->ignore($this->user()->id),
    //         ],

    //         // 🔴 ADD THIS (CRITICAL FIX)
    //         'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    //     ];
    // }
    public function rules(): array
{
    return [
        'name' => ['required', 'string', 'max:255'],

        'email' => [
            'required',
            'string',
            'lowercase',
            'email',
            'max:255',
            Rule::unique(User::class)->ignore($this->user()->id),
        ],

        // 🔥 ADD THIS (CRITICAL FIX)
        'profile_photo' => ['nullable', 'image', 'max:2048'],
    ];
}
}