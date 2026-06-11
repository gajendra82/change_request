<x-admin-layout>
    @include('admin.partials.page-header', [
        'title' => $client->company_name,
        'subtitle' => $client->company_code,
        'action' => '<a href="'.route('admin.clients.edit', $client).'" class="btn-crms-secondary">Edit</a>',
    ])
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="crms-card"><div class="crms-card-body">
                <div class="detail-grid">
                    <div class="detail-item"><label>GST</label><p>{{ $client->gst_number ?? '—' }}</p></div>
                    <div class="detail-item"><label>Website</label><p>{{ $client->website ?? '—' }}</p></div>
                    <div class="detail-item"><label>Contact</label><p>{{ $client->primary_contact_name }}</p></div>
                    <div class="detail-item"><label>Email</label><p>{{ $client->primary_contact_email }}</p></div>
                    <div class="detail-item" style="grid-column:1/-1"><label>Address</label><p>{{ $client->address }}, {{ $client->city }}, {{ $client->state }} {{ $client->pincode }}</p></div>
                </div>
            </div></div>
        </div>
        <div class="col-lg-4">
            <div class="crms-card"><div class="crms-card-header"><h5>Users ({{ $client->users->count() }})</h5></div>
                <div class="crms-card-body">@forelse($client->users as $u)<div class="small py-1">{{ $u->name }} — {{ $u->email }}</div>@empty<p class="text-muted small">No users</p>@endforelse</div>
            </div>
            <div class="crms-card mt-3"><div class="crms-card-header"><h5>Projects ({{ $client->projects->count() }})</h5></div>
                <div class="crms-card-body">@forelse($client->projects as $p)<div class="small py-1">{{ $p->name }} ({{ $p->code }})</div>@empty<p class="text-muted small">No projects</p>@endforelse</div>
            </div>
        </div>
    </div>
</x-admin-layout>
