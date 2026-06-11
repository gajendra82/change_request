<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'All Users', 'subtitle' => 'Unified user listing'])
    <div class="crms-card">
        <div class="crms-filters">
            <form method="GET" class="d-flex flex-wrap gap-2 w-100">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}" style="max-width:200px">
                <select name="role" class="form-select" style="max-width:140px"><option value="">All Roles</option>@foreach(['admin','client','developer','manager'] as $r)<option value="{{ $r }}" @selected(request('role')===$r)>{{ ucfirst($r) }}</option>@endforeach</select>
                <select name="client_id" class="form-select" style="max-width:160px"><option value="">All Clients</option>@foreach($clients as $c)<option value="{{ $c->id }}" @selected(request('client_id')==$c->id)>{{ $c->company_name }}</option>@endforeach</select>
                <select name="status" class="form-select" style="max-width:120px"><option value="">Status</option><option value="active" @selected(request('status')==='active')>Active</option><option value="inactive" @selected(request('status')==='inactive')>Inactive</option></select>
                <button type="submit" class="btn-crms-secondary">Filter</button>
            </form>
        </div>
        <div class="crms-table-wrapper">
            <table class="crms-table datatable mb-0">
                <thead><tr><th>Photo</th><th>Name</th><th>Role</th><th>Company</th><th>Email</th><th>Mobile</th><th>Status</th><th>Last Login</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td><div class="crms-user-avatar" style="width:32px;height:32px;font-size:0.7rem">{{ $u->initials }}</div></td>
                            <td>{{ $u->name }}</td>
                            <td><span class="crms-badge {{ $u->role_badge_class }}">{{ ucfirst($u->role) }}</span></td>
                            <td>{{ $u->client?->company_name ?? '—' }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->mobile ?? '—' }}</td>
                            <td><span class="status-dot {{ $u->status }}"></span> {{ ucfirst($u->status) }}</td>
                            <td>{{ $u->last_login_at?->diffForHumans() ?? 'Never' }}</td>
                            <td><a href="{{ route('admin.users.show', $u) }}" class="btn-crms-icon"><i data-lucide="eye" style="width:14px;height:14px"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $users->links() }}</div>
    </div>
</x-admin-layout>
