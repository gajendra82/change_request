<x-app-layout>
    <div class="crms-page-header mb-4">
        <h1>Edit {{ $changeRequest->cr_number }}</h1>
        <p class="subtitle">Update your change request details</p>
    </div>

    <div class="crms-card">
        <div class="crms-card-body">
            <form method="POST" action="{{ route('change-requests.update', $changeRequest) }}">
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

                <div class="form-floating-crms">
                    <select id="priority" name="priority" required class="@error('priority') is-invalid @enderror">
                        @foreach(['low', 'medium', 'high', 'critical'] as $priority)
                            <option value="{{ $priority }}" @selected(old('priority', $changeRequest->priority) === $priority)>{{ ucfirst($priority) }}</option>
                        @endforeach
                    </select>
                    <label for="priority">Priority Level</label>
                    @error('priority')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
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
