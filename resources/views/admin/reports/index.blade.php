<x-admin-layout>
    @include('admin.partials.page-header', ['title' => 'Reports'])
    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="kpi-card"><div class="kpi-label">Total Revenue</div><div class="kpi-value" style="font-size:1.25rem">₹{{ number_format($stats['total_revenue'], 0) }}</div></div></div>
        <div class="col-md-3"><div class="kpi-card"><div class="kpi-label">Clients</div><div class="kpi-value">{{ $stats['clients'] }}</div></div></div>
        <div class="col-md-3"><div class="kpi-card"><div class="kpi-label">Projects</div><div class="kpi-value">{{ $stats['projects'] }}</div></div></div>
    </div>
    <div class="row g-4">
        <div class="col-md-6"><div class="crms-card"><div class="crms-card-header"><h5>By Status</h5></div><div class="crms-card-body">@foreach($stats['by_status'] as $status => $count)<div class="d-flex justify-content-between py-2 border-bottom"><span>{{ ucfirst(str_replace('_',' ',$status)) }}</span><strong>{{ $count }}</strong></div>@endforeach</div></div></div>
        <div class="col-md-6"><div class="crms-card"><div class="crms-card-header"><h5>By Priority</h5></div><div class="crms-card-body">@foreach($stats['by_priority'] as $priority => $count)<div class="d-flex justify-content-between py-2 border-bottom"><span>{{ ucfirst($priority) }}</span><strong>{{ $count }}</strong></div>@endforeach</div></div></div>
    </div>
</x-admin-layout>
