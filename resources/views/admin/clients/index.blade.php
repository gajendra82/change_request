<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => 'Client Management',
        'subtitle' => 'Manage company clients',
        'action' => '<a href="'.route('admin.clients.create').'" class="btn-crms-primary"><i data-lucide="plus" style="width:16px;height:16px"></i> Add Client</a>',
    ])

    <div class="crms-card">
        <div class="crms-filters">
            <form method="GET" class="d-flex flex-wrap gap-2 w-100">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}" style="max-width:240px">
                <select name="status" class="form-select" style="max-width:140px">
                    <option value="">All Status</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                </select>
                <button type="submit" class="btn-crms-secondary">Filter</button>
            </form>
        </div>
        <div class="crms-table-wrapper">
            <table class="crms-table datatable mb-0">
                <thead>
                    <tr>
                        <th>Logo</th><th>Company</th><th>Code</th><th>Contact</th><th>Email</th><th>Status</th><th>Created</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>
                                @if($client->logo)
                                    <img src="{{ $client->logo_url }}" class="client-logo-thumb" alt="">
                                @else
                                    <div class="client-logo-thumb">{{ strtoupper(substr($client->company_name, 0, 2)) }}</div>
                                @endif
                            </td>
                            <td><strong>{{ $client->company_name }}</strong></td>
                            <td>{{ $client->company_code }}</td>
                            <td>{{ $client->primary_contact_name }}</td>
                            <td>{{ $client->primary_contact_email }}</td>
                            <td><span class="crms-badge {{ $client->status === 'active' ? 'badge-status-approved' : 'badge-priority-low' }}">{{ ucfirst($client->status) }}</span></td>
                            <td>{{ $client->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.clients.show', $client) }}" class="btn-crms-icon"><i data-lucide="eye" style="width:14px;height:14px"></i></a>
                                    <a href="{{ route('admin.clients.edit', $client) }}" class="btn-crms-icon"><i data-lucide="pencil" style="width:14px;height:14px"></i></a>
                                    <form action="{{ route('admin.clients.toggle-status', $client) }}" method="POST">@csrf
                                        <button class="btn-crms-icon" title="Toggle status"><i data-lucide="power" style="width:14px;height:14px"></i></button>
                                    </form>
                                    <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Delete this client?')">@csrf @method('DELETE')
                                        <button class="btn-crms-icon text-danger"><i data-lucide="trash-2" style="width:14px;height:14px"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $clients->links() }}</div>
    </div>
</x-admin-layout>
