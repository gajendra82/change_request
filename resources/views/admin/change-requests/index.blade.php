<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Change Requests'])
    <div class="crms-card">
        <div class="crms-filters">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search CR#" value="{{ request('search') }}" style="max-width:200px">
                <select name="status" class="form-select" style="max-width:160px"><option value="">All Status</option>@foreach(['submitted','timeline_added','approved','rejected','completed'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select>
                <button type="submit" class="btn-crms-secondary">Filter</button>
            </form>
        </div>
        <div class="crms-table-wrapper">
            <table class="crms-table datatable mb-0">
                <thead><tr><th>CR#</th><th>Title</th><th>Client</th><th>Project</th><th>Priority</th><th>Status</th><th>Date</th><th></th></tr></thead>
                <tbody>
                    @foreach($changeRequests as $cr)
                        <tr>
                            <td><strong>{{ $cr->cr_number }}</strong></td>
                            <td>{{ Str::limit($cr->title, 35) }}</td>
                            <td>{{ $cr->client->name ?? '—' }}</td>
                            <td>{{ $cr->project?->name ?? '—' }}</td>
                            <td><span class="crms-badge {{ $cr->priority_badge_class }}">{{ ucfirst($cr->priority) }}</span></td>
                            <td><span class="crms-badge {{ $cr->status_badge_class }}">{{ $cr->status_label }}</span></td>
                            <td>{{ $cr->created_at->format('d M Y') }}</td>
                            <td><a href="{{ route('admin.change-requests.show', $cr) }}" class="btn-crms-icon"><i data-lucide="eye" style="width:14px;height:14px"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $changeRequests->links() }}</div>
    </div>
</x-admin-layout>
