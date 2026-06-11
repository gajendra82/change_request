<x-app-layout>
    <div class="crms-page-header d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h1 class="mb-0">{{ $changeRequest->cr_number }}</h1>
                <span class="crms-badge {{ $changeRequest->status_badge_class }}">{{ $changeRequest->status_label }}</span>
            </div>
            <p class="subtitle">{{ $changeRequest->title }}</p>
        </div>
        <div class="header-actions">
            @if($changeRequest->status === 'submitted')
                <a href="{{ route('change-requests.edit', $changeRequest) }}" class="btn-crms-secondary">
                    <i data-lucide="pencil" style="width:16px;height:16px"></i> Edit
                </a>
                <form method="POST" action="{{ route('change-requests.destroy', $changeRequest) }}" class="d-inline" onsubmit="return confirm('Delete this change request?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-crms-secondary text-danger">
                        <i data-lucide="trash-2" style="width:16px;height:16px"></i> Delete
                    </button>
                </form>
            @endif
            <a href="{{ route('change-requests.index') }}" class="btn-crms-secondary">
                <i data-lucide="arrow-left" style="width:16px;height:16px"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="crms-card mb-4">
                <div class="crms-card-header"><h5>Request Information</h5></div>
                <div class="crms-card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>CR Number</label>
                            <p class="fw-semibold">{{ $changeRequest->cr_number }}</p>
                        </div>
                        <div class="detail-item">
                            <label>Priority</label>
                            <p><span class="crms-badge {{ $changeRequest->priority_badge_class }}">{{ ucfirst($changeRequest->priority) }}</span></p>
                        </div>
                        <div class="detail-item">
                            <label>Status</label>
                            <p><span class="crms-badge {{ $changeRequest->status_badge_class }}">{{ $changeRequest->status_label }}</span></p>
                        </div>
                        <div class="detail-item">
                            <label>Submitted</label>
                            <p>{{ $changeRequest->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <div class="detail-item" style="grid-column: 1 / -1">
                            <label>Description</label>
                            <p>{{ $changeRequest->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($changeRequest->timeline)
                <div class="crms-card mb-4">
                    <div class="crms-card-header"><h5>Timeline Information</h5></div>
                    <div class="crms-card-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Estimated Days</label>
                                <p class="fw-semibold">{{ $changeRequest->timeline->estimated_days }} days</p>
                            </div>
                            <div class="detail-item">
                                <label>Cost</label>
                                <p class="fw-semibold text-primary">₹{{ number_format($changeRequest->timeline->cost, 2) }}</p>
                            </div>
                            <div class="detail-item">
                                <label>Start Date</label>
                                <p>{{ $changeRequest->timeline->start_date->format('d M Y') }}</p>
                            </div>
                            <div class="detail-item">
                                <label>End Date</label>
                                <p>{{ $changeRequest->timeline->end_date->format('d M Y') }}</p>
                            </div>
                            <div class="detail-item">
                                <label>Developer</label>
                                <p>{{ $changeRequest->timeline->developer->name ?? '—' }}</p>
                            </div>
                            <div class="detail-item">
                                <label>Developer Notes</label>
                                <p>{{ $changeRequest->timeline->remarks ?? '—' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="crms-card mb-4">
                    <div class="crms-card-header"><h5>Approval Information</h5></div>
                    <div class="crms-card-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Manager Status</label>
                                <p><span class="crms-badge {{ $changeRequest->timeline->manager_status_badge_class }}">{{ ucfirst($changeRequest->timeline->manager_status) }}</span></p>
                            </div>
                            @if($changeRequest->timeline->approver)
                                <div class="detail-item">
                                    <label>Reviewed By</label>
                                    <p>{{ $changeRequest->timeline->approver->name }}</p>
                                </div>
                            @endif
                            @if($changeRequest->timeline->manager_remarks)
                                <div class="detail-item" style="grid-column: 1 / -1">
                                    <label>Manager Remarks</label>
                                    <p>{{ $changeRequest->timeline->manager_remarks }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="crms-card">
                <div class="crms-card-header"><h5>Activity History</h5></div>
                <div class="crms-card-body">
                    @include('partials.activity-history')
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="crms-card mb-4 lift">
                <div class="crms-card-header"><h5>Progress Timeline</h5></div>
                <div class="crms-card-body">
                    @include('partials.progress-timeline')
                </div>
            </div>

            @if($changeRequest->timeline)
                <div class="cost-highlight-card mb-4">
                    <div class="cost-label">Estimated Cost</div>
                    <div class="cost-value">₹{{ number_format($changeRequest->timeline->cost, 0) }}</div>
                    <div class="cost-days">{{ $changeRequest->timeline->estimated_days }} days &middot; {{ $changeRequest->timeline->start_date->format('d M') }} — {{ $changeRequest->timeline->end_date->format('d M Y') }}</div>
                </div>
            @else
                <div class="crms-card">
                    <div class="crms-card-body text-center py-4">
                        <i data-lucide="clock" style="width:32px;height:32px;color:#94A3B8" class="mb-2"></i>
                        <p class="text-muted small mb-0">Awaiting developer timeline estimation</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
