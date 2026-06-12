<x-guest-layout>
    <div class="auth-card">
        <div class="auth-logo">
            <div class="logo-icon">
                <i data-lucide="git-pull-request" style="width:22px;height:22px"></i>
            </div>
            <h1>{{ config('app.name') }}</h1>
        </div>

        <div class="auth-welcome">
            <h2>Welcome back</h2>
            <p>Sign in to manage your change requests</p>
        </div>

        @if (session('status'))
            <div class="crms-alert crms-alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-floating-crms">
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder=" " required autofocus
                       class="@error('email') is-invalid @enderror">
                <label for="email">Email Address</label>
                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="form-floating-crms">
                <input type="password" id="password" name="password" placeholder=" " required
                       class="@error('password') is-invalid @enderror">
                <label for="password">Password</label>
                @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label small" for="remember_me">Remember me</label>
            </div>

            <button type="submit" class="btn-crms-primary w-100 justify-content-center py-3">
                <i data-lucide="log-in" style="width:18px;height:18px"></i>
                Sign In
            </button>

            @if (Route::has('password.request'))
                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="small text-muted text-decoration-none">Forgot your password?</a>
                </div>
            @endif
        </form>
    </div>
</x-guest-layout>
