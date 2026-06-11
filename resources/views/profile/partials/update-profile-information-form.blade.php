<section>
    <p class="text-muted small mb-3">Update your account's profile information and email address.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="form-text">
                    Your email address is unverified.
                    <button form="send-verification" class="btn btn-link btn-sm p-0">Resend verification email</button>
                </div>
                @if (session('status') === 'verification-link-sent')
                    <div class="text-success small mt-1">A new verification link has been sent.</div>
                @endif
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <div><span class="crms-badge {{ $user->role_badge_class }}">{{ ucfirst($user->role) }}</span></div>
        </div>

        <button type="submit" class="btn-crms-primary">Save</button>
        @if (session('status') === 'profile-updated')
            <span class="text-success ms-2 small">Saved.</span>
        @endif
    </form>
</section>
