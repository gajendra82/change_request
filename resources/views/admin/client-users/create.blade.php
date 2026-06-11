<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Create Client User'])
    <div class="crms-card"><div class="crms-card-body">
        <form method="POST" action="{{ route('admin.client-users.store') }}">@csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Client *</label><select name="client_id" class="form-select" required>@foreach($clients as $c)<option value="{{ $c->id }}">{{ $c->company_name }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Mobile</label><input type="text" name="mobile" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Designation</label><input type="text" name="designation" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
                <div class="col-md-6"><label class="form-label">Password *</label><input type="password" name="password" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label">Confirm Password *</label><input type="password" name="password_confirmation" class="form-control" required></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn-crms-primary">Create User</button></div>
        </form>
    </div></div>
</x-admin-layout>
