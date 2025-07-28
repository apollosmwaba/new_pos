<?php
// ✅ VERIFIED - Graph View Consistency on 2024-12-19
// REASON: Graph view already matches POS2 layout and functionality exactly
// No changes needed - both systems use identical Chart.js implementation

// Debug: Output the graph data for troubleshooting
if (!isset($graph_data) || empty($graph_data)) {
    echo '<div style="color:red;">No graph data available. Please check your sales data or controller logic.</div>';
} else {
    echo '<!-- Graph data: ' . htmlspecialchars(json_encode($graph_data)) . ' -->';
}
?>
<div class="graph-container" style="max-width: 900px; margin: 0 auto; padding: 40px 0;">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
        <h2 style="margin: 0; font-weight: 700; color: #2c3e50;"><i class="fa fa-chart-bar"></i> Sales Graph</h2>
        <form method="get" style="margin: 0;">
            <input type="hidden" name="pg" value="admin">
            <input type="hidden" name="tab" value="graph">
            <select name="graph_period" onchange="this.form.submit()" style="padding: 7px 14px; border-radius: 6px; border: 1px solid #ccc; font-size: 16px;">
                <option value="day" <?=isset($_GET['graph_period']) && $_GET['graph_period']==='day' ? 'selected' : ''?>>Today (by hour)</option>
                <option value="month" <?=isset($_GET['graph_period']) && $_GET['graph_period']==='month' ? 'selected' : ''?>>This Month (by day)</option>
                <option value="year" <?=isset($_GET['graph_period']) && $_GET['graph_period']==='year' ? 'selected' : ''?>>This Year (by month)</option>
            </select>
        </form>
    </div>
    <canvas id="salesChart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const graphData = <?=json_encode($graph_data)?>;
    const ctx = document.getElementById('salesChart').getContext('2d');
    const labels = graphData.map(item => item.label);
    const data = graphData.map(item => item.total);
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales (K)',
                data: data,
                fill: true,
                borderColor: '#e74c3c',
                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                tension: 0.3,
                pointBackgroundColor: '#e74c3c',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#2c3e50', callback: value => 'K' + value }
                },
                x: {
                    ticks: { color: '#2c3e50' }
                }
            }
        }
    });
</script> 