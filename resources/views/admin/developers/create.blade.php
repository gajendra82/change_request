<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Add Developer'])
    <div class="crms-card"><div class="crms-card-body">
        <form method="POST" action="{{ route('admin.developers.store') }}" enctype="multipart/form-data">@csrf
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Employee ID *</label><input type="text" name="employee_id" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Mobile</label><input type="text" name="mobile" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Department</label><input type="text" name="department" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Experience</label><input type="text" name="experience" class="form-control" placeholder="e.g. 5 years"></div>
                <div class="col-12"><label class="form-label">Skills</label><textarea name="skills" class="form-control" rows="2"></textarea></div>
                <div class="col-md-4"><label class="form-label">Password *</label><input type="password" name="password" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Confirm *</label><input type="password" name="password_confirmation" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Photo</label><input type="file" name="profile_photo" class="form-control" accept="image/*"></div>
                <div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn-crms-primary">Create Developer</button></div>
        </form>
    </div></div>
</x-admin-layout>
