<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Edit Manager', 'subtitle' => $manager->name])
    <div class="crms-card"><div class="crms-card-body">
        <form method="POST" action="{{ route('admin.managers.update', $manager) }}" enctype="multipart/form-data">@csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Employee ID *</label><input type="text" name="employee_id" class="form-control" value="{{ $manager->employee_id }}" required></div>
                <div class="col-md-4"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" value="{{ $manager->name }}" required></div>
                <div class="col-md-4"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="{{ $manager->email }}" required></div>
                <div class="col-md-4"><label class="form-label">Mobile</label><input type="text" name="mobile" class="form-control" value="{{ $manager->mobile }}"></div>
                <div class="col-md-4"><label class="form-label">Department</label><input type="text" name="department" class="form-control" value="{{ $manager->department }}"></div>
                <div class="col-md-4"><label class="form-label">Designation</label><input type="text" name="designation" class="form-control" value="{{ $manager->designation }}"></div>
                <div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" @selected($manager->status==='active')>Active</option><option value="inactive" @selected($manager->status==='inactive')>Inactive</option></select></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn-crms-primary">Update</button></div>
        </form>
    </div></div>
</x-admin-layout>
