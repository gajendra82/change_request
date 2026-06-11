<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeveloperRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|string|max:50|unique:users,employee_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'mobile' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:100',
            'experience' => 'nullable|string|max:100',
            'skills' => 'nullable|string|max:1000',
            'password' => 'required|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ];
    }
}
