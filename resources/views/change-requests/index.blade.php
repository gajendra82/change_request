<x-app-layout>
    <div class="crms-page-header d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1>Change Requests</h1>
            <p class="subtitle">Manage and track all your change requests</p>
        </div>
        <a href="{{ route('change-requests.create') }}" class="btn-crms-primary">
            <i data-lucide="plus" style="width:18px;height:18px"></i> New Change Request
        </a>
    </div>

    <div class="crms-card">
        <div class="crms-card-body p-0">
            @include('partials.change-request-table', ['changeRequests' => $changeRequests, 'showClient' => false])
        </div>
    </div>
</x-app-layout>
