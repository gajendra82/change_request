<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'company_code' => 'required|string|max:50|unique:clients,company_code',
            'gst_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'primary_contact_name' => 'required|string|max:255',
            'primary_contact_email' => 'required|email|max:255',
            'primary_contact_mobile' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'logo' => 'nullable|image|max:2048',
            'notes' => 'nullable|string|max:2000',
        ];
    }
}
