<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Edit Client', 'subtitle' => $client->company_name])
    <div class="crms-card"><div class="crms-card-body">
        <form method="POST" action="{{ route('admin.clients.update', $client) }}" enctype="multipart/form-data">@csrf @method('PUT')
            @include('admin.clients._form', ['client' => $client])
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn-crms-primary">Update Client</button>
                <a href="{{ route('admin.clients.index') }}" class="btn-crms-secondary">Cancel</a>
            </div>
        </form>
    </div></div>
</x-admin-layout>
