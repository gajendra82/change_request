<x-app-layout>
    <div class="crms-page-header mb-4">
        <h1>Timeline Approvals</h1>
        <p class="subtitle">Review and approve developer timeline estimations</p>
    </div>

    <div class="crms-card mb-4">
        <div class="crms-card-header">
            <h5><i data-lucide="clipboard-check" style="width:18px;height:18px" class="me-1"></i> Pending Review</h5>
            <span class="crms-badge badge-manager-pending">{{ $pendingTimelines->count() }} pending</span>
        </div>
        <div class="crms-card-body p-0">
            <div class="crms-table-wrapper">
                <table class="crms-table datatable mb-0">
                    <thead>
                        <tr>
                            <th>CR Number</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Developer</th>
                            <th>Priority</th>
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
                                <td>{{ $timeline->changeRequest->title }}</td>
                                <td>{{ $timeline->changeRequest->client->name }}</td>
                                <td>{{ $timeline->developer->name }}</td>
                                <td><span class="crms-badge {{ $timeline->changeRequest->priority_badge_class }}">{{ ucfirst($timeline->changeRequest->priority) }}</span></td>
                                <td>{{ $timeline->estimated_days }}</td>
                                <td>₹{{ number_format($timeline->cost, 0) }}</td>
                                <td>{{ $timeline->start_date->format('d M') }} — {{ $timeline->end_date->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('manager.timelines.show', $timeline) }}" class="btn-crms-primary btn-sm py-1 px-3" style="font-size:0.75rem">Review</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-muted py-4">No timelines pending review</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="crms-card">
        <div class="crms-card-header">
            <h5><i data-lucide="history" style="width:18px;height:18px" class="me-1"></i> Reviewed Timelines</h5>
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviewedTimelines as $timeline)
                            <tr>
                                <td><strong>{{ $timeline->changeRequest->cr_number }}</strong></td>
                                <td><span class="crms-badge {{ $timeline->manager_status_badge_class }}">{{ ucfirst($timeline->manager_status) }}</span></td>
                                <td>₹{{ number_format($timeline->cost, 0) }}</td>
                                <td>{{ $timeline->approver?->name ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('manager.timelines.show', $timeline) }}" class="btn-crms-icon"><i data-lucide="eye" style="width:16px;height:16px"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No reviewed timelines yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
