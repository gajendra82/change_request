<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Projects', 'action' => '<a href="'.route('admin.projects.create').'" class="btn-crms-primary">Add Project</a>'])
    <div class="crms-card">
        <div class="crms-table-wrapper">
            <table class="crms-table datatable mb-0">
                <thead><tr><th>Code</th><th>Name</th><th>Client</th><th>Manager</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($projects as $p)
                        <tr>
                            <td><strong>{{ $p->code }}</strong></td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->client->company_name }}</td>
                            <td>{{ $p->projectManager?->name ?? '—' }}</td>
                            <td><span class="crms-badge badge-status-submitted">{{ ucfirst(str_replace('_',' ',$p->status)) }}</span></td>
                            <td>
                                <a href="{{ route('admin.projects.edit', $p) }}" class="btn-crms-icon"><i data-lucide="pencil" style="width:14px;height:14px"></i></a>
                                <form action="{{ route('admin.projects.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn-crms-icon text-danger"><i data-lucide="trash-2" style="width:14px;height:14px"></i></button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $projects->links() }}</div>
    </div>
</x-admin-layout>
