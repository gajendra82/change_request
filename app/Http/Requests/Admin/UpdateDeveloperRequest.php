<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDeveloperRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($this->route('developer'))],
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->route('developer'))],
            'mobile' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:100',
            'experience' => 'nullable|string|max:100',
            'skills' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ];
    }
}
