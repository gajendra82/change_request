<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->route('client_user'))],
            'mobile' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
        ];
    }
}
