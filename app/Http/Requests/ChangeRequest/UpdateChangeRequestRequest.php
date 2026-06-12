<?php

namespace App\Http\Requests\ChangeRequest;

use App\Models\ChangeRequest;
use App\Services\ChangeRequestAttachmentService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateChangeRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isClient() ?? false;
    }

    public function rules(): array
    {
        return array_merge([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'in:low,medium,high,critical'],
        ], ChangeRequestAttachmentService::validationRules());
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            /** @var ChangeRequest|null $changeRequest */
            $changeRequest = $this->route('change_request');

            if (! $changeRequest) {
                return;
            }

            if ($this->filled('remove_attachments')) {
                $validCount = $changeRequest->attachments()
                    ->whereIn('id', $this->input('remove_attachments'))
                    ->count();

                if ($validCount !== count($this->input('remove_attachments'))) {
                    $validator->errors()->add('remove_attachments', 'One or more attachments are invalid.');
                }
            }

            $remaining = $changeRequest->attachments()->count();
            $removeCount = count($this->input('remove_attachments', []));
            $newCount = count($this->file('attachments', []));

            if (($remaining - $removeCount + $newCount) > ChangeRequestAttachmentService::MAX_FILES) {
                $validator->errors()->add('attachments', 'A maximum of '.ChangeRequestAttachmentService::MAX_FILES.' attachments is allowed.');
            }
        });
    }
}
