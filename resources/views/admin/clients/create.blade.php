<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Create Client', 'subtitle' => 'Add a new company client'])
    <div class="crms-card"><div class="crms-card-body">
        <form method="POST" action="{{ route('admin.clients.store') }}" enctype="multipart/form-data">@csrf
            @include('admin.clients._form')
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn-crms-primary">Create Client</button>
                <a href="{{ route('admin.clients.index') }}" class="btn-crms-secondary">Cancel</a>
            </div>
        </form>
    </div></div>
</x-admin-layout>
