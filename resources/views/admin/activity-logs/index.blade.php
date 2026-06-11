<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Activity Logs'])
    <div class="crms-card">
        <div class="crms-filters">
            <form method="GET" class="d-flex flex-wrap gap-2 w-100">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}" style="max-width:200px">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" style="max-width:150px">
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" style="max-width:150px">
                <button type="submit" class="btn-crms-secondary">Filter</button>
            </form>
        </div>
        <div class="crms-table-wrapper">
            <table class="crms-table datatable mb-0">
                <thead><tr><th>Date</th><th>User</th><th>Action</th><th>Description</th><th>IP</th><th>Device</th></tr></thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $log->user?->name ?? 'System' }}</td>
                            <td><span class="crms-badge badge-status-submitted">{{ str_replace('_', ' ', $log->action) }}</span></td>
                            <td>{{ Str::limit($log->description, 50) }}</td>
                            <td>{{ $log->ip_address }}</td>
                            <td><small>{{ Str::limit($log->user_agent, 30) }}</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $logs->links() }}</div>
    </div>
</x-admin-layout>
