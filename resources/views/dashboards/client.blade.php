<x-app-layout>
    <div class="crms-page-header d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <h1>Welcome back, {{ $user->name }}</h1>
            <p class="subtitle">Here's an overview of your change requests</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('change-requests.create') }}" class="btn-crms-primary">
                <i data-lucide="plus" style="width:18px;height:18px"></i> New Request
            </a>
        </div>
    </div>

    @include('partials.kpi-cards')
    @include('partials.dashboard-charts')

    <div class="crms-card">
        <div class="crms-card-header">
            <h5><i data-lucide="list" style="width:18px;height:18px" class="me-1"></i> Recent Change Requests</h5>
            <a href="{{ route('change-requests.index') }}" class="btn-crms-secondary btn-sm">View All</a>
        </div>
        <div class="crms-card-body p-0">
            @include('partials.change-request-table', ['changeRequests' => $changeRequests, 'showClient' => false])
        </div>
    </div>
</x-app-layout>
