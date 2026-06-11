<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Edit Project', 'subtitle' => $project->name])
    <div class="crms-card"><div class="crms-card-body">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}">@csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Project Name *</label><input type="text" name="name" class="form-control" value="{{ $project->name }}" required></div>
                <div class="col-md-6"><label class="form-label">Project Code *</label><input type="text" name="code" class="form-control" value="{{ $project->code }}" required></div>
                <div class="col-md-6"><label class="form-label">Client *</label><select name="client_id" class="form-select" required>@foreach($clients as $c)<option value="{{ $c->id }}" @selected($project->client_id==$c->id)>{{ $c->company_name }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Project Manager</label><select name="project_manager_id" class="form-select"><option value="">— None —</option>@foreach($managers as $m)<option value="{{ $m->id }}" @selected($project->project_manager_id==$m->id)>{{ $m->name }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" value="{{ $project->start_date?->format('Y-m-d') }}"></div>
                <div class="col-md-4"><label class="form-label">End Date</label><input type="date" name="end_date" class="form-control" value="{{ $project->end_date?->format('Y-m-d') }}"></div>
                <div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['active','on_hold','completed','cancelled'] as $s)<option value="{{ $s }}" @selected($project->status===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
                <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ $project->description }}</textarea></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn-crms-primary">Update</button></div>
        </form>
    </div></div>
</x-admin-layout>
