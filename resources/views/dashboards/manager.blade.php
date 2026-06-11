<x-app-layout>
    <div class="crms-page-header">
        <h1>Welcome back, {{ auth()->user()->name }}</h1>
        <p class="subtitle">Review and approve timeline estimations</p>
    </div>

    @include('partials.kpi-cards')
    @include('partials.dashboard-charts')

    <div class="crms-card mb-4">
        <div class="crms-card-header">
            <h5><i data-lucide="clipboard-check" style="width:18px;height:18px" class="me-1"></i> Pending Approvals</h5>
            <a href="{{ route('manager.timelines.index') }}" class="btn-crms-secondary btn-sm">View All</a>
        </div>
        <div class="crms-card-body p-0">
            <div class="crms-table-wrapper">
                <table class="crms-table datatable mb-0">
                    <thead>
                        <tr>
                            <th>CR Number</th>
                            <th>Client</th>
                            <th>Developer</th>
                            <th>Days</th>
                            <th>Cost</th>
                            <th>Timeline</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingTimelines as $timeline)
                            <tr>
                                <td><strong>{{ $timeline->changeRequest->cr_number }}</strong></td>
                                <td>{{ $timeline->changeRequest->client->name }}</td>
                                <td>{{ $timeline->developer->name }}</td>
                                <td>{{ $timeline->estimated_days }}</td>
                                <td>₹{{ number_format($timeline->cost, 0) }}</td>
                                <td>{{ $timeline->start_date->format('d M') }} — {{ $timeline->end_date->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('manager.timelines.show', $timeline) }}" class="btn-crms-primary btn-sm py-1 px-3" style="font-size:0.75rem">Review</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">No pending approvals</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="crms-card">
        <div class="crms-card-header">
            <h5><i data-lucide="history" style="width:18px;height:18px" class="me-1"></i> Recently Reviewed</h5>
        </div>
        <div class="crms-card-body p-0">
            <div class="crms-table-wrapper">
                <table class="crms-table datatable mb-0">
                    <thead>
                        <tr>
                            <th>CR Number</th>
                            <th>Status</th>
                            <th>Cost</th>
                            <th>Reviewed By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviewedTimelines as $timeline)
                            <tr>
                                <td>{{ $timeline->changeRequest->cr_number }}</td>
                                <td><span class="crms-badge {{ $timeline->manager_status_badge_class }}">{{ ucfirst($timeline->manager_status) }}</span></td>
                                <td>₹{{ number_format($timeline->cost, 0) }}</td>
                                <td>{{ $timeline->approver?->name ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No reviewed timelines yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
