<x-app-layout>
    <div class="crms-page-header mb-4">
        <h1>Timeline Estimation</h1>
        <p class="subtitle">{{ $changeRequest->cr_number }} — {{ $changeRequest->title }}</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="crms-card lift">
                <div class="crms-card-header"><h5>Change Request Summary</h5></div>
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
                            <label>Client</label>
                            <p>{{ $changeRequest->client->name }}</p>
                        </div>
                        <div class="detail-item">
                            <label>Submitted</label>
                            <p>{{ $changeRequest->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="detail-item" style="grid-column: 1 / -1">
                            <label>Description</label>
                            <p class="small">{{ $changeRequest->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="crms-card">
                <div class="crms-card-header"><h5>Timeline Entry</h5></div>
                <div class="crms-card-body">
                    <form method="POST" action="{{ route('timelines.store', $changeRequest) }}">
                        @csrf

                        <div class="form-floating-crms">
                            <input type="number" id="estimated_days" name="estimated_days" data-daily-rate="12000"
                                   value="{{ old('estimated_days', 5) }}" min="1" max="365" placeholder=" " required
                                   class="@error('estimated_days') is-invalid @enderror">
                            <label for="estimated_days">Estimated Days</label>
                            @error('estimated_days')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating-crms">
                                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" placeholder=" " required
                                           class="@error('start_date') is-invalid @enderror">
                                    <label for="start_date">Start Date</label>
                                    @error('start_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating-crms">
                                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" placeholder=" " required
                                           class="@error('end_date') is-invalid @enderror">
                                    <label for="end_date">End Date</label>
                                    @error('end_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-floating-crms">
                            <textarea id="remarks" name="remarks" placeholder=" " rows="4"
                                      class="@error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
                            <label for="remarks">Remarks / Notes</label>
                            @error('remarks')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="cost-highlight-card mb-4">
                            <div class="cost-label">Auto-Calculated Cost</div>
                            <div class="cost-value" id="estimated_cost">₹60,000.00</div>
                            <div class="cost-days"><span id="cost_days_display">5 days</span> × ₹12,000/day</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-crms-primary">
                                <i data-lucide="save" style="width:16px;height:16px"></i> Save Timeline
                            </button>
                            <a href="{{ route('timelines.index') }}" class="btn-crms-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
