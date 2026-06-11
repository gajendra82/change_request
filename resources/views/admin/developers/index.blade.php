<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Developers', 'action' => '<a href="'.route('admin.developers.create').'" class="btn-crms-primary">Add Developer</a>'])
    <div class="crms-card">
        <div class="crms-table-wrapper">
            <table class="crms-table datatable mb-0">
                <thead><tr><th>Photo</th><th>Emp ID</th><th>Name</th><th>Email</th><th>Department</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($developers as $d)
                        <tr>
                            <td><div class="crms-user-avatar" style="width:32px;height:32px;font-size:0.7rem">{{ $d->initials }}</div></td>
                            <td>{{ $d->employee_id }}</td>
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->email }}</td>
                            <td>{{ $d->department ?? '—' }}</td>
                            <td><span class="crms-badge {{ $d->status === 'active' ? 'badge-status-approved' : 'badge-priority-low' }}">{{ ucfirst($d->status) }}</span></td>
                            <td><a href="{{ route('admin.developers.edit', $d) }}" class="btn-crms-icon"><i data-lucide="pencil" style="width:14px;height:14px"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $developers->links() }}</div>
    </div>
</x-admin-layout>
