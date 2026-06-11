<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Admin Profile'])
    <div class="crms-card" style="max-width:600px"><div class="crms-card-body">
        <form method="POST" action="{{ route('admin.profile.update') }}">@csrf @method('PATCH')
            <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $user->email }}" required></div>
            <button type="submit" class="btn-crms-primary">Save Profile</button>
        </form>
    </div></div>
</x-admin-layout>
