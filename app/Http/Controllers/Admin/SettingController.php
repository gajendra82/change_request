<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCompanySettingsRequest;
use App\Http\Requests\Admin\UpdateNotificationSettingsRequest;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(private SettingService $settings) {}

    public function index(): View
    {
        $company = [
            'company_name' => Setting::get('company_name', ''),
            'company_address' => Setting::get('company_address', ''),
            'company_email' => Setting::get('company_email', ''),
            'company_phone' => Setting::get('company_phone', ''),
            'company_gst' => Setting::get('company_gst', ''),
            'company_logo' => Setting::get('company_logo'),
            'default_cost_per_day' => Setting::get('default_cost_per_day', 12000),
        ];

        $notifications = [
            'notify_email' => Setting::getBool('notify_email', true),
            'notify_approval' => Setting::getBool('notify_approval', true),
            'notify_completion' => Setting::getBool('notify_completion', true),
            'notify_new_cr' => Setting::getBool('notify_new_cr', true),
        ];

        return view('admin.settings.index', compact('company', 'notifications'));
    }

    public function updateCompany(UpdateCompanySettingsRequest $request): RedirectResponse
    {
        $this->settings->updateCompanySettings($request->validated());

        return back()->with('success', 'Company settings updated.');
    }

    public function updateNotifications(UpdateNotificationSettingsRequest $request): RedirectResponse
    {
        $this->settings->updateNotificationSettings($request->validated());

        return back()->with('success', 'Notification settings updated.');
    }
}
