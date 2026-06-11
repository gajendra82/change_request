<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CRMS') }} @isset($title) - {{ $title }} @endisset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/crms.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="crms-wrapper">
        @include('layouts.partials.sidebar')

        <div class="crms-main">
            @include('layouts.partials.topbar')

            <div class="crms-content">
                @include('components.alert')
                {{ $slot }}
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function () {
            $('.datatable').each(function () {
                if (!$.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable({
                        responsive: true,
                        order: [[0, 'desc']],
                        language: { search: '', searchPlaceholder: 'Search...' },
                        dom: '<"d-flex justify-content-between align-items-center px-3 py-2"lf>rt<"d-flex justify-content-between align-items-center px-3 py-2"ip>',
                    });
                }
            });
        });
    </script>
    <script src="{{ asset('js/crms.js') }}"></script>
    @stack('scripts')
</body>
</html>
