<x-admin-layout>
    @include('admin.partials.page-header', ['title' => $user->name, 'subtitle' => ucfirst($user->role)])
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="crms-card text-center"><div class="crms-card-body py-4">
                <div class="crms-user-avatar mx-auto mb-3" style="width:80px;height:80px;font-size:2rem">{{ $user->initials }}</div>
                <h5>{{ $user->name }}</h5>
                <span class="crms-badge {{ $user->role_badge_class }}">{{ ucfirst($user->role) }}</span>
                <p class="text-muted small mt-2 mb-0">{{ $user->email }}</p>
            </div></div>
        </div>
        <div class="col-lg-8">
            <div class="crms-card mb-4"><div class="crms-card-header"><h5>Personal Information</h5></div><div class="crms-card-body">
                <div class="detail-grid">
                    <div class="detail-item"><label>Mobile</label><p>{{ $user->mobile ?? '—' }}</p></div>
                    <div class="detail-item"><label>Company</label><p>{{ $user->client?->company_name ?? '—' }}</p></div>
                    <div class="detail-item"><label>Department</label><p>{{ $user->department ?? '—' }}</p></div>
                    <div class="detail-item"><label>Employee ID</label><p>{{ $user->employee_id ?? '—' }}</p></div>
                </div>
            </div></div>
            <div class="crms-card"><div class="crms-card-header"><h5>Login History</h5></div><div class="crms-card-body">
                @forelse($loginHistory as $log)
                    <div class="small py-2 border-bottom">{{ str_replace('_',' ',$log->action) }} — {{ $log->created_at->format('d M Y h:i A') }} — {{ $log->ip_address }}</div>
                @empty
                    <p class="text-muted small">No login history</p>
                @endforelse
            </div></div>
        </div>
    </div>
</x-admin-layout>
