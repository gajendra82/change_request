<x-app-layout>
    <div class="crms-page-header mb-4">
        <h1>Edit Timeline</h1>
        <p class="subtitle">{{ $timeline->changeRequest->cr_number }} — {{ $timeline->changeRequest->title }}</p>
    </div>

    <div class="crms-card">
        <div class="crms-card-body">
            <form method="POST" action="{{ route('timelines.update', $timeline) }}">
                @csrf @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="form-floating-crms">
                            <input type="number" id="estimated_days" name="estimated_days" data-daily-rate="12000"
                                   value="{{ old('estimated_days', $timeline->estimated_days) }}" min="1" max="365" placeholder=" " required
                                   class="@error('estimated_days') is-invalid @enderror">
                            <label for="estimated_days">Estimated Days</label>
                            @error('estimated_days')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating-crms">
                                    <input type="date" id="start_date" name="start_date"
                                           value="{{ old('start_date', $timeline->start_date->format('Y-m-d')) }}" placeholder=" " required
                                           class="@error('start_date') is-invalid @enderror">
                                    <label for="start_date">Start Date</label>
                                    @error('start_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating-crms">
                                    <input type="date" id="end_date" name="end_date"
                                           value="{{ old('end_date', $timeline->end_date->format('Y-m-d')) }}" placeholder=" " required
                                           class="@error('end_date') is-invalid @enderror">
                                    <label for="end_date">End Date</label>
                                    @error('end_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-floating-crms">
                            <textarea id="remarks" name="remarks" placeholder=" " rows="4"
                                      class="@error('remarks') is-invalid @enderror">{{ old('remarks', $timeline->remarks) }}</textarea>
                            <label for="remarks">Remarks</label>
                            @error('remarks')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="cost-highlight-card">
                            <div class="cost-label">Estimated Cost</div>
                            <div class="cost-value" id="estimated_cost">₹{{ number_format($timeline->cost, 2) }}</div>
                            <div class="cost-days"><span id="cost_days_display">{{ $timeline->estimated_days }} days</span> × ₹12,000/day</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-3 border-top mt-2">
                    <button type="submit" class="btn-crms-primary">
                        <i data-lucide="save" style="width:16px;height:16px"></i> Update Timeline
                    </button>
                    <a href="{{ route('timelines.index') }}" class="btn-crms-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
