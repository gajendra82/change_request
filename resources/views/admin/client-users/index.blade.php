<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Client Users', 'subtitle' => 'Manage client portal users', 'action' => '<a href="'.route('admin.client-users.create').'" class="btn-crms-primary"><i data-lucide="plus" style="width:16px;height:16px"></i> Add User</a>'])
    <div class="crms-card">
        <div class="crms-filters">
            <form method="GET" class="d-flex flex-wrap gap-2 w-100">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}" style="max-width:200px">
                <select name="client_id" class="form-select" style="max-width:180px"><option value="">All Clients</option>@foreach($clients as $c)<option value="{{ $c->id }}" @selected(request('client_id') == $c->id)>{{ $c->company_name }}</option>@endforeach</select>
                <button type="submit" class="btn-crms-secondary">Filter</button>
            </form>
        </div>
        <div class="crms-table-wrapper">
            <table class="crms-table datatable mb-0">
                <thead><tr><th>Name</th><th>Client</th><th>Email</th><th>Mobile</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($clientUsers as $u)
                        <tr>
                            <td><strong>{{ $u->name }}</strong></td>
                            <td>{{ $u->client?->company_name ?? '—' }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->mobile ?? '—' }}</td>
                            <td><span class="crms-badge {{ $u->status === 'active' ? 'badge-status-approved' : 'badge-priority-low' }}">{{ ucfirst($u->status) }}</span></td>
                            <td>
                                <a href="{{ route('admin.client-users.edit', $u) }}" class="btn-crms-icon"><i data-lucide="pencil" style="width:14px;height:14px"></i></a>
                                <form action="{{ route('admin.client-users.toggle-status', $u) }}" method="POST" class="d-inline">@csrf<button class="btn-crms-icon"><i data-lucide="power" style="width:14px;height:14px"></i></button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $clientUsers->links() }}</div>
    </div>
</x-admin-layout>
