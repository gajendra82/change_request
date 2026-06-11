<?php

namespace App\Http\Requests\Timeline;

use Illuminate\Foundation\Http\FormRequest;

class ManagerReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isManager() ?? false;
    }

    public function rules(): array
    {
        return [
            'manager_remarks' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
