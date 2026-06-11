<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Settings'])
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="crms-card"><div class="crms-card-header"><h5>Company Information</h5></div><div class="crms-card-body">
                <form method="POST" action="{{ route('admin.settings.company') }}" enctype="multipart/form-data">@csrf @method('PUT')
                    <div class="mb-3"><label class="form-label">Company Name</label><input type="text" name="company_name" class="form-control" value="{{ $company['company_name'] }}" required></div>
                    <div class="mb-3"><label class="form-label">Address</label><textarea name="company_address" class="form-control" rows="2">{{ $company['company_address'] }}</textarea></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="company_email" class="form-control" value="{{ $company['company_email'] }}" required></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="company_phone" class="form-control" value="{{ $company['company_phone'] }}"></div>
                    <div class="mb-3"><label class="form-label">GST</label><input type="text" name="company_gst" class="form-control" value="{{ $company['company_gst'] }}"></div>
                    <div class="mb-3"><label class="form-label">Default Cost Per Day (₹)</label><input type="number" name="default_cost_per_day" class="form-control" value="{{ $company['default_cost_per_day'] }}" min="1" required>
                        <div class="form-text">Formula: Total Cost = Estimated Days × Cost Per Day</div>
                    </div>
                    <div class="mb-3"><label class="form-label">Company Logo</label><input type="file" name="company_logo" class="form-control" accept="image/*"></div>
                    <button type="submit" class="btn-crms-primary">Save Company Settings</button>
                </form>
            </div></div>
        </div>
        <div class="col-lg-6">
            <div class="crms-card"><div class="crms-card-header"><h5>Notification Settings</h5></div><div class="crms-card-body">
                <form method="POST" action="{{ route('admin.settings.notifications') }}">@csrf @method('PUT')
                    @foreach(['notify_email' => 'Email Notifications', 'notify_approval' => 'Approval Notifications', 'notify_completion' => 'Completion Notifications', 'notify_new_cr' => 'New Change Request Notifications'] as $key => $label)
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="{{ $key }}" value="1" id="{{ $key }}" @checked($notifications[$key])>
                            <label class="form-check-label" for="{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    <button type="submit" class="btn-crms-primary">Save Notifications</button>
                </form>
            </div></div>
        </div>
    </div>
</x-admin-layout>
