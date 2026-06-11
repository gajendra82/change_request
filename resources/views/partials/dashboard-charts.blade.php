<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="chart-card">
            <h6><i data-lucide="trending-up" style="width:16px;height:16px" class="me-1"></i> Monthly Change Requests</h6>
            <div id="chartMonthly"></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="chart-card">
            <h6><i data-lucide="pie-chart" style="width:16px;height:16px" class="me-1"></i> Status Distribution</h6>
            <div id="chartStatus"></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="chart-card">
            <h6><i data-lucide="indian-rupee" style="width:16px;height:16px" class="me-1"></i> Revenue Projection</h6>
            <div id="chartRevenue"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartData = @json($chartData);

    new ApexCharts(document.querySelector('#chartMonthly'), {
        chart: { type: 'area', height: 280, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
        series: [{ name: 'Change Requests', data: chartData.monthly.values }],
        xaxis: { categories: chartData.monthly.labels, labels: { style: { fontSize: '11px' } } },
        colors: ['#2563EB'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05 } },
        stroke: { curve: 'smooth', width: 2 },
        dataLabels: { enabled: false },
        grid: { borderColor: '#E2E8F0', strokeDashArray: 4 },
        tooltip: { theme: 'light' },
    }).render();

    new ApexCharts(document.querySelector('#chartStatus'), {
        chart: { type: 'donut', height: 280, fontFamily: 'Inter, sans-serif' },
        series: chartData.status.values,
        labels: chartData.status.labels,
        colors: ['#2563EB', '#F59E0B', '#10B981', '#EF4444', '#8B5CF6'],
        legend: { position: 'bottom', fontSize: '11px' },
        plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '12px' } } } } },
        dataLabels: { enabled: false },
    }).render();

    new ApexCharts(document.querySelector('#chartRevenue'), {
        chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
        series: [{ name: 'Revenue (₹)', data: chartData.revenue.values }],
        xaxis: { categories: chartData.revenue.labels, labels: { style: { fontSize: '10px' }, rotate: -45 } },
        colors: ['#10B981'],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
        dataLabels: { enabled: false },
        grid: { borderColor: '#E2E8F0', strokeDashArray: 4 },
        yaxis: { labels: { formatter: function (v) { return '₹' + v.toLocaleString('en-IN'); } } },
        tooltip: { y: { formatter: function (v) { return '₹' + v.toLocaleString('en-IN'); } } },
    }).render();

    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>
@endpush
