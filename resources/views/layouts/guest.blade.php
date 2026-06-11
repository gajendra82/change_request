<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CRMS') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/crms.css') }}" rel="stylesheet">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-illustration">
            <div class="auth-illustration-content">
                <div class="auth-illustration-svg">
                    <svg width="320" height="240" viewBox="0 0 320 240" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="40" y="30" width="240" height="160" rx="16" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                        <rect x="60" y="55" width="80" height="12" rx="6" fill="rgba(255,255,255,0.3)"/>
                        <rect x="60" y="80" width="160" height="8" rx="4" fill="rgba(255,255,255,0.15)"/>
                        <rect x="60" y="96" width="120" height="8" rx="4" fill="rgba(255,255,255,0.15)"/>
                        <rect x="60" y="120" width="60" height="24" rx="12" fill="#10B981"/>
                        <rect x="130" y="120" width="60" height="24" rx="12" fill="rgba(255,255,255,0.2)"/>
                        <circle cx="200" cy="150" r="30" fill="rgba(37,99,235,0.4)" stroke="#60A5FA" stroke-width="2"/>
                        <path d="M190 150 L198 158 L212 142" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <rect x="80" y="170" width="160" height="6" rx="3" fill="rgba(255,255,255,0.1)"/>
                        <rect x="80" y="170" width="100" height="6" rx="3" fill="#2563EB"/>
                    </svg>
                </div>
                <h2>Manage Change Requests Efficiently</h2>
                <p>Streamline your software development workflow with intelligent timeline estimation, manager approvals, and real-time project tracking.</p>
            </div>
        </div>

        <div class="auth-form-panel">
            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>if (typeof lucide !== 'undefined') lucide.createIcons();</script>
</body>
</html>
