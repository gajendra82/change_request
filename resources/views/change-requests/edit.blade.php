<x-app-layout>
    <div class="crms-page-header mb-4">
        <h1>Edit {{ $changeRequest->cr_number }}</h1>
        <p class="subtitle">Update your change request details</p>
    </div>

    <div class="crms-card">
        <div class="crms-card-body">
            <form method="POST" action="{{ route('change-requests.update', $changeRequest) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="form-floating-crms">
                    <input type="text" id="title" name="title" value="{{ old('title', $changeRequest->title) }}" placeholder=" " required
                           class="@error('title') is-invalid @enderror">
                    <label for="title">Request Title</label>
                    @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="form-floating-crms">
                    <textarea id="description" name="description" placeholder=" " required rows="5"
                              class="@error('description') is-invalid @enderror">{{ old('description', $changeRequest->description) }}</textarea>
                    <label for="description">Business Requirement</label>
                    @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="form-floating-crms form-floating-crms--select">
                    <select id="priority" name="priority" required class="@error('priority') is-invalid @enderror">
                        @foreach(['low', 'medium', 'high', 'critical'] as $priority)
                            <option value="{{ $priority }}" @selected(old('priority', $changeRequest->priority) === $priority)>{{ ucfirst($priority) }}</option>
                        @endforeach
                    </select>
                    <label for="priority">Priority Level</label>
                    @error('priority')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                @if($changeRequest->attachments->isNotEmpty())
                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-muted text-uppercase">Current Attachments</label>
                        <ul class="attachment-list list-unstyled mb-0">
                            @foreach($changeRequest->attachments as $attachment)
                                <li class="attachment-item">
                                    <label class="attachment-remove-label">
                                        <input type="checkbox" name="remove_attachments[]" value="{{ $attachment->id }}"
                                               @checked(in_array($attachment->id, old('remove_attachments', [])))>
                                        <span>Remove</span>
                                    </label>
                                    <a href="{{ route('change-requests.attachments.download', [$changeRequest, $attachment]) }}" class="attachment-link">
                                        <i data-lucide="file-text" style="width:16px;height:16px"></i>
                                        <span>{{ $attachment->original_name }}</span>
                                        <span class="text-muted small">({{ $attachment->human_size }})</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="form-label fw-semibold small text-muted text-uppercase">Add Attachments</label>
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
                </div>

                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn-crms-primary">
                        <i data-lucide="save" style="width:16px;height:16px"></i> Update Request
                    </button>
                    <a href="{{ route('change-requests.show', $changeRequest) }}" class="btn-crms-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
