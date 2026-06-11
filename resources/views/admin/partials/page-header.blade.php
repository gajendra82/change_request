<div class="crms-page-header d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h1>{{ $title }}</h1>
        @isset($subtitle)<p class="subtitle">{{ $subtitle }}</p>@endisset
    </div>
    @isset($action)
        <div class="header-actions">{!! $action !!}</div>
    @endisset
</div>
