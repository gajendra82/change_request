<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'notify_email' => 'nullable|boolean',
            'notify_approval' => 'nullable|boolean',
            'notify_completion' => 'nullable|boolean',
            'notify_new_cr' => 'nullable|boolean',
        ];
    }
}
