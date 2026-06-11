@php
    $showClient = $showClient ?? true;
@endphp

<div data-crms-filters
     data-status-col="{{ $showClient ? 4 : 3 }}"
     data-priority-col="{{ $showClient ? 3 : 2 }}"
     data-date-col="{{ $showClient ? 5 : 4 }}">
    <div class="crms-filters">
        <div class="crms-search-input">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" class="form-control" data-filter-search placeholder="Search change requests...">
        </div>
        <select class="form-select" data-filter-status style="max-width:160px">
            <option value="">All Status</option>
            <option value="Submitted">Submitted</option>
            <option value="Timeline Added">Timeline Added</option>
            <option value="Approved">Approved</option>
            <option value="Rejected">Rejected</option>
            <option value="Completed">Completed</option>
        </select>
        <select class="form-select" data-filter-priority style="max-width:140px">
            <option value="">All Priority</option>
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
            <option value="Critical">Critical</option>
        </select>
        <input type="date" class="form-control" data-filter-date-from style="max-width:150px" title="From date">
        <input type="date" class="form-control" data-filter-date-to style="max-width:150px" title="To date">
    </div>

    <div class="crms-table-desktop">
        <div class="crms-table-wrapper">
            <table class="crms-table datatable mb-0">
                <thead>
                    <tr>
                        <th>CR Number</th>
                        <th>Title</th>
                        @if($showClient)<th>Client</th>@endif
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($changeRequests as $cr)
                        <tr>
                            <td><strong>{{ $cr->cr_number }}</strong></td>
                            <td>{{ $cr->title }}</td>
                            @if($showClient)<td>{{ $cr->client->name ?? auth()->user()->name }}</td>@endif
                            <td><span class="crms-badge {{ $cr->priority_badge_class }}">{{ ucfirst($cr->priority) }}</span></td>
                            <td><span class="crms-badge {{ $cr->status_badge_class }}">{{ $cr->status_label }}</span></td>
                            <td>{{ $cr->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('change-requests.show', $cr) }}" class="btn-crms-icon" title="View"><i data-lucide="eye" style="width:16px;height:16px"></i></a>
                                    @if($cr->status === 'submitted')
                                        <a href="{{ route('change-requests.edit', $cr) }}" class="btn-crms-icon" title="Edit"><i data-lucide="pencil" style="width:16px;height:16px"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ $showClient ? 7 : 6 }}" class="text-center text-muted py-5">No change requests found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="crms-table-mobile p-3">
        @forelse($changeRequests as $cr)
            <div class="mobile-card-item">
                <div class="mc-header">
                    <div>
                        <div class="mc-title">{{ $cr->cr_number }}</div>
                        <div class="small">{{ $cr->title }}</div>
                    </div>
                    <span class="crms-badge {{ $cr->status_badge_class }}">{{ $cr->status_label }}</span>
                </div>
                <div class="mc-meta d-flex justify-content-between">
                    <span class="crms-badge {{ $cr->priority_badge_class }}">{{ ucfirst($cr->priority) }}</span>
                    <span>{{ $cr->created_at->format('d M Y') }}</span>
                </div>
                <div class="mt-2 d-flex gap-1">
                    <a href="{{ route('change-requests.show', $cr) }}" class="btn-crms-primary btn-sm py-1 px-3" style="font-size:0.75rem">View</a>
                    @if($cr->status === 'submitted')
                        <a href="{{ route('change-requests.edit', $cr) }}" class="btn-crms-secondary btn-sm py-1 px-3" style="font-size:0.75rem">Edit</a>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">No change requests found</div>
        @endforelse
    </div>
</div>
