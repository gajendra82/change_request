<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanySettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string|max:500',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'nullable|string|max:30',
            'company_gst' => 'nullable|string|max:50',
            'default_cost_per_day' => 'required|numeric|min:1',
            'company_logo' => 'nullable|image|max:2048',
        ];
    }
}
