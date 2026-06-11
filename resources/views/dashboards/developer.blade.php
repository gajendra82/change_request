<x-app-layout>
    <div class="crms-page-header">
        <h1>Welcome back, {{ $user->name }}</h1>
        <p class="subtitle">Manage timelines and track pending change requests</p>
    </div>

    @include('partials.kpi-cards')
    @include('partials.dashboard-charts')

    <div class="crms-card mb-4">
        <div class="crms-card-header">
            <h5><i data-lucide="inbox" style="width:18px;height:18px" class="me-1"></i> Pending Change Requests</h5>
            <a href="{{ route('timelines.index') }}" class="btn-crms-secondary btn-sm">View All</a>
        </div>
        <div class="crms-card-body p-0">
            <div class="crms-table-wrapper">
                <table class="crms-table datatable mb-0">
                    <thead>
                        <tr>
                            <th>CR Number</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Priority</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingRequests as $cr)
                            <tr>
                                <td><strong>{{ $cr->cr_number }}</strong></td>
                                <td>{{ $cr->title }}</td>
                                <td>{{ $cr->client->name }}</td>
                                <td><span class="crms-badge {{ $cr->priority_badge_class }}">{{ ucfirst($cr->priority) }}</span></td>
                                <td>{{ $cr->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('timelines.create', $cr) }}" class="btn-crms-primary btn-sm py-1 px-3" style="font-size:0.75rem">
                                        <i data-lucide="calendar-plus" style="width:14px;height:14px"></i> Add Timeline
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">No pending requests</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="crms-card">
        <div class="crms-card-header">
            <h5><i data-lucide="calendar-range" style="width:18px;height:18px" class="me-1"></i> My Timelines</h5>
        </div>
        <div class="crms-card-body p-0">
            <div class="crms-table-wrapper">
                <table class="crms-table datatable mb-0">
                    <thead>
                        <tr>
                            <th>CR Number</th>
                            <th>Days</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($timelinesAdded as $timeline)
                            <tr>
                                <td><strong>{{ $timeline->changeRequest->cr_number }}</strong></td>
                                <td>{{ $timeline->estimated_days }} days</td>
                                <td>₹{{ number_format($timeline->cost, 0) }}</td>
                                <td><span class="crms-badge {{ $timeline->manager_status_badge_class }}">{{ ucfirst($timeline->manager_status) }}</span></td>
                                <td>
                                    @if($timeline->manager_status === 'pending')
                                        <a href="{{ route('timelines.edit', $timeline) }}" class="btn-crms-icon"><i data-lucide="pencil" style="width:16px;height:16px"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No timelines added yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
