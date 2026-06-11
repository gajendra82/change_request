<?php

namespace App\Http\Requests\Timeline;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimelineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isDeveloper() ?? false;
    }

    public function rules(): array
    {
        return [
            'estimated_days' => ['required', 'integer', 'min:1', 'max:365'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'remarks' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
