<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Managers', 'action' => '<a href="'.route('admin.managers.create').'" class="btn-crms-primary">Add Manager</a>'])
    <div class="crms-card">
        <div class="crms-table-wrapper">
            <table class="crms-table datatable mb-0">
                <thead><tr><th>Emp ID</th><th>Name</th><th>Email</th><th>Designation</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($managers as $m)
                        <tr>
                            <td>{{ $m->employee_id }}</td>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->email }}</td>
                            <td>{{ $m->designation ?? '—' }}</td>
                            <td><span class="crms-badge {{ $m->status === 'active' ? 'badge-status-approved' : 'badge-priority-low' }}">{{ ucfirst($m->status) }}</span></td>
                            <td><a href="{{ route('admin.managers.edit', $m) }}" class="btn-crms-icon"><i data-lucide="pencil" style="width:14px;height:14px"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $managers->links() }}</div>
    </div>
</x-admin-layout>
