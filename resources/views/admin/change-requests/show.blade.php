<x-admin-layout>
    @include('admin.partials.page-header', ['title' => $changeRequest->cr_number, 'subtitle' => $changeRequest->title])
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="crms-card"><div class="crms-card-body">
                <div class="detail-grid">
                    <div class="detail-item"><label>Client User</label><p>{{ $changeRequest->client->name }}</p></div>
                    <div class="detail-item"><label>Project</label><p>{{ $changeRequest->project?->name ?? '—' }}</p></div>
                    <div class="detail-item"><label>Priority</label><p><span class="crms-badge {{ $changeRequest->priority_badge_class }}">{{ ucfirst($changeRequest->priority) }}</span></p></div>
                    <div class="detail-item"><label>Status</label><p><span class="crms-badge {{ $changeRequest->status_badge_class }}">{{ $changeRequest->status_label }}</span></p></div>
                    <div class="detail-item" style="grid-column:1/-1"><label>Description</label><p>{{ $changeRequest->description }}</p></div>
                </div>
            </div></div>
            @include('partials.change-request-attachments')
        </div>
        @if($changeRequest->timeline)
            <div class="col-lg-4">
                <div class="cost-highlight-card">
                    <div class="cost-label">Timeline Cost</div>
                    <div class="cost-value">₹{{ number_format($changeRequest->timeline->cost, 0) }}</div>
                    <div class="cost-days">{{ $changeRequest->timeline->estimated_days }} days</div>
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
