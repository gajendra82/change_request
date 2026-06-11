<section>
    <p class="text-muted small mb-3">Ensure your account is using a long, random password to stay secure.</p>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Current Password</label>
            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" id="update_password_current_password" name="current_password">
            @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">New Password</label>
            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="update_password_password" name="password">
            @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn-crms-primary">Save</button>
        @if (session('status') === 'password-updated')
            <span class="text-success ms-2 small">Saved.</span>
        @endif
    </form>
</section>
