<x-app-layout>
    <div class="crms-page-header mb-4">
        <h1>Create Change Request</h1>
        <p class="subtitle">Submit a new change request in 4 simple steps</p>
    </div>

    <div class="crms-card">
        <div class="crms-card-body">
            <div id="crWizard">
                <div class="wizard-progress">
                    <div class="wizard-step active" data-step="1">
                        <div class="wizard-step-circle">1</div>
                        <span class="wizard-step-label">Basic Info</span>
                    </div>
                    <div class="wizard-step" data-step="2">
                        <div class="wizard-step-circle">2</div>
                        <span class="wizard-step-label">Requirements</span>
                    </div>
                    <div class="wizard-step" data-step="3">
                        <div class="wizard-step-circle">3</div>
                        <span class="wizard-step-label">Attachments</span>
                    </div>
                    <div class="wizard-step" data-step="4">
                        <div class="wizard-step-circle">4</div>
                        <span class="wizard-step-label">Review</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('change-requests.store') }}" id="crWizardForm" data-draft-key="new" enctype="multipart/form-data">
                    @csrf

                    <div class="wizard-panel active" data-step="1">
                        <h5 class="fw-semibold mb-3">Basic Information</h5>
                        <div class="form-floating-crms">
                            <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder=" " required
                                   class="@error('title') is-invalid @enderror">
                            <label for="title">Request Title</label>
                            @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-floating-crms form-floating-crms--select">
                            <select id="priority" name="priority" required class="@error('priority') is-invalid @enderror">
                                <option value="" disabled @selected(!old('priority'))>Select priority</option>
                                @foreach(['low', 'medium', 'high', 'critical'] as $priority)
                                    <option value="{{ $priority }}" @selected(old('priority') === $priority)>{{ ucfirst($priority) }}</option>
                                @endforeach
                            </select>
                            <label for="priority">Priority Level</label>
                            @error('priority')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="wizard-panel" data-step="2">
                        <h5 class="fw-semibold mb-3">Business Requirement</h5>
                        <div class="form-floating-crms">
                            <textarea id="description" name="description" placeholder=" " required rows="6"
                                      class="@error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            <label for="description">Describe the business requirement in detail</label>
                            @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="wizard-panel" data-step="3">
                        <h5 class="fw-semibold mb-3">Attachments</h5>
                        <p class="text-muted small mb-3">Upload supporting documents, mockups, or specifications (optional)</p>
                        <div class="drop-zone" id="dropZone">
                            <i data-lucide="upload-cloud" class="drop-icon"></i>
                            <div class="fw-semibold">Drag & drop files here</div>
                            <div class="text-muted small">or click to browse</div>
                            <input type="file" id="fileInput" name="attachments[]" multiple class="d-none"
                                   accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.xls,.xlsx,.zip">
                        </div>
                        <div id="fileList"></div>
                        @error('attachments')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                        @error('attachments.*')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                        <div class="text-muted small mt-2">
                            <i data-lucide="info" style="width:14px;height:14px"></i>
                            PDF, DOC, DOCX, PNG, JPG, XLS, XLSX, ZIP — max 10 MB per file, up to 10 files.
                        </div>
                    </div>

                    <div class="wizard-panel" data-step="4">
                        <h5 class="fw-semibold mb-3">Review & Submit</h5>
                        <div class="crms-card bg-light border-0">
                            <div class="crms-card-body">
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <label>Title</label>
                                        <p id="reviewTitle" class="fw-semibold">—</p>
                                    </div>
                                    <div class="detail-item">
                                        <label>Priority</label>
                                        <p id="reviewPriority" class="fw-semibold">—</p>
                                    </div>
                                    <div class="detail-item" style="grid-column: 1 / -1">
                                        <label>Description</label>
                                        <p id="reviewDescription">—</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <button type="button" id="wizardPrev" class="btn-crms-secondary" style="display:none">
                            <i data-lucide="arrow-left" style="width:16px;height:16px"></i> Previous
                        </button>
                        <div class="ms-auto d-flex gap-2">
                            <a href="{{ route('change-requests.index') }}" class="btn-crms-secondary">Cancel</a>
                            <button type="button" id="wizardNext" class="btn-crms-primary">
                                Next <i data-lucide="arrow-right" style="width:16px;height:16px"></i>
                            </button>
                            <button type="submit" id="wizardSubmit" class="btn-crms-primary" style="display:none">
                                <i data-lucide="send" style="width:16px;height:16px"></i> Submit Request
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
