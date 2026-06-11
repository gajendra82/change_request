<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Edit Client User', 'subtitle' => $client_user->name])
    <div class="crms-card"><div class="crms-card-body">
        <form method="POST" action="{{ route('admin.client-users.update', $client_user) }}">@csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Client *</label><select name="client_id" class="form-select" required>@foreach($clients as $c)<option value="{{ $c->id }}" @selected($client_user->client_id == $c->id)>{{ $c->company_name }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" value="{{ old('name', $client_user->name) }}" required></div>
                <div class="col-md-6"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="{{ old('email', $client_user->email) }}" required></div>
                <div class="col-md-6"><label class="form-label">Mobile</label><input type="text" name="mobile" class="form-control" value="{{ old('mobile', $client_user->mobile) }}"></div>
                <div class="col-md-6"><label class="form-label">Designation</label><input type="text" name="designation" class="form-control" value="{{ old('designation', $client_user->designation) }}"></div>
                <div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" @selected($client_user->status === 'active')>Active</option><option value="inactive" @selected($client_user->status === 'inactive')>Inactive</option></select></div>
                <div class="col-md-6"><label class="form-label">New Password</label><input type="password" name="password" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Confirm Password</label><input type="password" name="password_confirmation" class="form-control"></div>
            </div>
            <div class="mt-4 d-flex gap-2"><button type="submit" class="btn-crms-primary">Update</button><a href="{{ route('admin.client-users.index') }}" class="btn-crms-secondary">Cancel</a></div>
        </form>
    </div></div>
</x-admin-layout>
