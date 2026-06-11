<x-admin-layout>
    <div class="admin-header-gradient">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }} — manage your CRMS platform</p>
    </div>

    <div class="row g-3 mb-4 admin-kpi-grid">
        @foreach([
            ['label' => 'Total Clients', 'value' => $stats['total_clients'], 'icon' => 'building-2'],
            ['label' => 'Client Users', 'value' => $stats['total_client_users'], 'icon' => 'users'],
            ['label' => 'Developers', 'value' => $stats['total_developers'], 'icon' => 'code-2'],
            ['label' => 'Managers', 'value' => $stats['total_managers'], 'icon' => 'briefcase'],
            ['label' => 'Projects', 'value' => $stats['total_projects'], 'icon' => 'folder-kanban'],
            ['label' => 'Open CRs', 'value' => $stats['open_change_requests'], 'icon' => 'file-text'],
            ['label' => 'Pending Approvals', 'value' => $stats['pending_approvals'], 'icon' => 'clock'],
            ['label' => 'Completed', 'value' => $stats['completed_requests'], 'icon' => 'check-circle'],
        ] as $kpi)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="kpi-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="kpi-label">{{ $kpi['label'] }}</div>
                            <div class="kpi-value">{{ $kpi['value'] }}</div>
                        </div>
                        <div class="kpi-icon primary"><i data-lucide="{{ $kpi['icon'] }}" style="width:20px;height:20px"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6"><div class="chart-card"><h6>Monthly Change Requests</h6><div id="adminChartMonthly"></div></div></div>
        <div class="col-lg-6"><div class="chart-card"><h6>Client-wise Requests</h6><div id="adminChartClients"></div></div></div>
        <div class="col-lg-6"><div class="chart-card"><h6>Project-wise Requests</h6><div id="adminChartProjects"></div></div></div>
        <div class="col-lg-6"><div class="chart-card"><h6>Developer Workload</h6><div id="adminChartDevelopers"></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="crms-card">
                <div class="crms-card-header"><h5>Recent Change Requests</h5></div>
                <div class="crms-card-body p-0">
                    <table class="crms-table mb-0">
                        <thead><tr><th>CR#</th><th>Title</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                            @forelse($recentChangeRequests as $cr)
                                <tr>
                                    <td><a href="{{ route('admin.change-requests.show', $cr) }}">{{ $cr->cr_number }}</a></td>
                                    <td>{{ Str::limit($cr->title, 30) }}</td>
                                    <td><span class="crms-badge {{ $cr->status_badge_class }}">{{ $cr->status_label }}</span></td>
                                    <td>{{ $cr->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">No data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="crms-card mb-4">
                <div class="crms-card-header"><h5>Pending Approvals</h5></div>
                <div class="crms-card-body">
                    @forelse($pendingApprovals as $tl)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <div class="fw-semibold small">{{ $tl->changeRequest->cr_number }}</div>
                                <div class="text-muted" style="font-size:0.75rem">{{ $tl->developer->name }}</div>
                            </div>
                            <span class="fw-semibold text-primary">₹{{ number_format($tl->cost, 0) }}</span>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No pending approvals</p>
                    @endforelse
                </div>
            </div>
            <div class="crms-card">
                <div class="crms-card-header"><h5>Latest Activities</h5></div>
                <div class="crms-card-body">
                    @forelse($recentActivities as $log)
                        <div class="py-2 border-bottom">
                            <div class="small fw-semibold">{{ str_replace('_', ' ', ucfirst($log->action)) }}</div>
                            <div class="text-muted" style="font-size:0.75rem">{{ $log->description }}</div>
                            <div class="text-muted" style="font-size:0.6875rem">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No activities yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const d = @json($chartData);
        const opts = { chart: { toolbar: { show: false }, fontFamily: 'Inter' }, dataLabels: { enabled: false } };
        new ApexCharts(document.querySelector('#adminChartMonthly'), { ...opts, chart: { ...opts.chart, type: 'area', height: 260 }, series: [{ name: 'CRs', data: d.monthly.values }], xaxis: { categories: d.monthly.labels }, colors: ['#2563EB'], stroke: { curve: 'smooth' } }).render();
        new ApexCharts(document.querySelector('#adminChartClients'), { ...opts, chart: { ...opts.chart, type: 'bar', height: 260 }, series: [{ name: 'Requests', data: d.clients.values }], xaxis: { categories: d.clients.labels }, colors: ['#8B5CF6'], plotOptions: { bar: { borderRadius: 6 } } }).render();
        new ApexCharts(document.querySelector('#adminChartProjects'), { ...opts, chart: { ...opts.chart, type: 'bar', height: 260 }, series: [{ name: 'Requests', data: d.projects.values }], xaxis: { categories: d.projects.labels }, colors: ['#10B981'], plotOptions: { bar: { borderRadius: 6 } } }).render();
        new ApexCharts(document.querySelector('#adminChartDevelopers'), { ...opts, chart: { ...opts.chart, type: 'donut', height: 260 }, series: d.developers.values, labels: d.developers.labels, colors: ['#2563EB','#10B981','#F59E0B','#EF4444','#8B5CF6'] }).render();
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
    </script>
    @endpush
</x-admin-layout>
