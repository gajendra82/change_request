<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    public function getDailyRate(): float
    {
        return Setting::getFloat('default_cost_per_day', 12000);
    }

    public function updateCompanySettings(array $data): void
    {
        $keys = ['company_name', 'company_address', 'company_email', 'company_phone', 'company_gst', 'default_cost_per_day'];

        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                Setting::set($key, $data[$key], 'company');
            }
        }

        if (isset($data['company_logo']) && $data['company_logo'] instanceof UploadedFile) {
            $path = $data['company_logo']->store('settings', 'public');
            Setting::set('company_logo', $path, 'company');
        }
    }

    public function updateNotificationSettings(array $data): void
    {
        $keys = ['notify_email', 'notify_approval', 'notify_completion', 'notify_new_cr'];

        foreach ($keys as $key) {
            Setting::set($key, isset($data[$key]) ? '1' : '0', 'notifications');
        }
    }

    public function seedDefaults(): void
    {
        $defaults = [
            'company_name' => 'Change Request Management System',
            'company_address' => '',
            'company_email' => 'admin@company.com',
            'company_phone' => '',
            'company_gst' => '',
            'default_cost_per_day' => '12000',
            'notify_email' => '1',
            'notify_approval' => '1',
            'notify_completion' => '1',
            'notify_new_cr' => '1',
        ];

        foreach ($defaults as $key => $value) {
            if (! Setting::query()->where('key', $key)->exists()) {
                Setting::set($key, $value, str_starts_with($key, 'notify_') ? 'notifications' : 'company');
            }
        }
    }
}
