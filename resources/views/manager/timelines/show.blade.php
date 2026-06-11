<x-app-layout>
    <div class="crms-page-header d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1>Review Timeline</h1>
            <p class="subtitle">{{ $timeline->changeRequest->cr_number }} — {{ $timeline->changeRequest->title }}</p>
        </div>
        <a href="{{ route('manager.timelines.index') }}" class="btn-crms-secondary">
            <i data-lucide="arrow-left" style="width:16px;height:16px"></i> Back
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="crms-card mb-4">
                <div class="crms-card-header"><h5>Change Request Details</h5></div>
                <div class="crms-card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Title</label>
                            <p class="fw-semibold">{{ $timeline->changeRequest->title }}</p>
                        </div>
                        <div class="detail-item">
                            <label>Client</label>
                            <p>{{ $timeline->changeRequest->client->name }}</p>
                        </div>
                        <div class="detail-item">
                            <label>Priority</label>
                            <p><span class="crms-badge {{ $timeline->changeRequest->priority_badge_class }}">{{ ucfirst($timeline->changeRequest->priority) }}</span></p>
                        </div>
                        <div class="detail-item">
                            <label>Developer</label>
                            <p>{{ $timeline->developer->name }}</p>
                        </div>
                        <div class="detail-item" style="grid-column: 1 / -1">
                            <label>Description</label>
                            <p>{{ $timeline->changeRequest->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="crms-card mb-4 lift">
                <div class="crms-card-header"><h5>Timeline Summary</h5></div>
                <div class="crms-card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Estimated Days</label>
                            <p class="fw-semibold fs-5">{{ $timeline->estimated_days }} days</p>
                        </div>
                        <div class="detail-item">
                            <label>Start Date</label>
                            <p>{{ $timeline->start_date->format('d M Y') }}</p>
                        </div>
                        <div class="detail-item">
                            <label>End Date</label>
                            <p>{{ $timeline->end_date->format('d M Y') }}</p>
                        </div>
                        <div class="detail-item">
                            <label>Status</label>
                            <p><span class="crms-badge {{ $timeline->manager_status_badge_class }}">{{ ucfirst($timeline->manager_status) }}</span></p>
                        </div>
                    </div>

                    <div class="cost-highlight-card mt-3">
                        <div class="cost-label">Total Cost</div>
                        <div class="cost-value">₹{{ number_format($timeline->cost, 0) }}</div>
                        <div class="cost-days">{{ $timeline->estimated_days }} days × ₹12,000/day</div>
                    </div>

                    @if($timeline->remarks)
                        <div class="mt-3 p-3 rounded-3" style="background:var(--crms-bg)">
                            <label class="small fw-semibold text-muted text-uppercase">Developer Notes</label>
                            <p class="mb-0 small mt-1">{{ $timeline->remarks }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($timeline->manager_status === 'pending')
                <div class="approval-card approve mb-3">
                    <h6 class="fw-semibold mb-3"><i data-lucide="check-circle" style="width:18px;height:18px" class="me-1"></i> Approve Timeline</h6>
                    <form method="POST" action="{{ route('manager.timelines.approve', $timeline) }}">
                        @csrf
                        <div class="form-floating-crms">
                            <textarea name="manager_remarks" placeholder=" " rows="3"></textarea>
                            <label>Approval Remarks (optional)</label>
                        </div>
                        <button type="submit" class="btn-crms-success">
                            <i data-lucide="check" style="width:18px;height:18px"></i> Approve
                        </button>
                    </form>
                </div>

                <div class="approval-card reject">
                    <h6 class="fw-semibold mb-3"><i data-lucide="x-circle" style="width:18px;height:18px" class="me-1"></i> Reject Timeline</h6>
                    <form method="POST" action="{{ route('manager.timelines.reject', $timeline) }}" onsubmit="return confirm('Reject this timeline?')">
                        @csrf
                        <div class="form-floating-crms">
                            <textarea name="manager_remarks" placeholder=" " rows="3"></textarea>
                            <label>Rejection Reason (optional)</label>
                        </div>
                        <button type="submit" class="btn-crms-danger">
                            <i data-lucide="x" style="width:18px;height:18px"></i> Reject
                        </button>
                    </form>
                </div>
            @elseif($timeline->manager_remarks)
                <div class="crms-card">
                    <div class="crms-card-header"><h5>Manager Remarks</h5></div>
                    <div class="crms-card-body">
                        <p class="mb-0">{{ $timeline->manager_remarks }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
