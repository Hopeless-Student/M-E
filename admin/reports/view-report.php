<?php
 require_once __DIR__ . '/../../auth/admin_auth.php';
 require_once __DIR__ . '/../../config/config.php';
 
 $reportType = isset($_GET['type']) ? $_GET['type'] : 'sales';
 $startDate = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
 $endDate = isset($_GET['end']) ? $_GET['end'] : date('Y-m-d');
 $groupBy = isset($_GET['group']) ? $_GET['group'] : 'month';
 
 $reportTitles = [
     'sales' => 'Sales Report',
     'inventory' => 'Inventory Report',
     'customers' => 'Customer Report',
     'orders' => 'Orders Report',
     'financial' => 'Financial Report'
 ];
 
 $reportTitle = $reportTitles[$reportType] ?? 'Business Report';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $reportTitle ?> - M & E Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/M&E_LOGO-semi-transparent.ico">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/reports/view-report.css">
</head>
<body>
    <div class="dashboard">
        <button class="mobile-menu-btn" data-sidebar-toggle="open">
            <i data-lucide="menu"></i>
        </button>

        <?php include '../../includes/admin_sidebar.php'; ?>

        <main class="main-content">
            <div class="header">
                <div class="header-left">
                    <h2><?= $reportTitle ?></h2>
                    <p class="header-subtitle">Period: <?= date('M d, Y', strtotime($startDate)) ?> - <?= date('M d, Y', strtotime($endDate)) ?></p>
                </div>
                <div class="header-actions">
                    <button class="btn btn-secondary" onclick="window.print()">
                        <i data-lucide="printer"></i> Print
                    </button>
                    <button class="btn btn-primary" onclick="downloadPDF()">
                        <i data-lucide="download"></i> Download PDF
                    </button>
                </div>
            </div>

            <div class="breadcrumb">
                <a href="../index.php">Dashboard</a>
                <span>></span>
                <a href="./index.php">Reports</a>
                <span>></span>
                <span><?= $reportTitle ?></span>
            </div>

            <!-- Report Content -->
            <div id="reportContent" class="report-container">
                <div class="loading-state">
                    <div class="spinner"></div>
                    <p>Loading report data...</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        const reportType = '<?= $reportType ?>';
        const startDate = '<?= $startDate ?>';
        const endDate = '<?= $endDate ?>';
        const groupBy = '<?= $groupBy ?>';

        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            loadReportData();
        });

        async function loadReportData() {
            try {
                const response = await fetch(`../../api/admin/reports/get-data.php?type=${reportType}&start=${startDate}&end=${endDate}&group=${groupBy}`);
                const data = await response.json();

                if (data.success) {
                    renderReport(data.report);
                } else {
                    showError(data.error || 'Failed to load report data');
                }
            } catch (error) {
                console.error('Error loading report:', error);
                showError('Error loading report data');
            }
        }

        function renderReport(report) {
            const container = document.getElementById('reportContent');
            
            let html = '';

            // Summary Cards
            if (report.summary) {
                html += '<div class="summary-grid">';
                for (const [key, value] of Object.entries(report.summary)) {
                    html += `
                        <div class="summary-card">
                            <span class="summary-label">${formatLabel(key)}</span>
                            <span class="summary-value">${formatValue(key, value)}</span>
                        </div>
                    `;
                }
                html += '</div>';
            }

            // Charts
            if (report.chartData) {
                html += `
                    <div class="chart-section">
                        <h3>Trend Analysis</h3>
                        <canvas id="trendChart"></canvas>
                    </div>
                `;
            }

            // Data Table
            if (report.tableData && report.tableData.length > 0) {
                html += '<div class="table-section">';
                html += '<h3>Detailed Data</h3>';
                html += '<div class="table-wrapper">';
                html += '<table class="data-table">';
                
                // Table Header
                html += '<thead><tr>';
                for (const column of report.columns) {
                    html += `<th>${column}</th>`;
                }
                html += '</tr></thead>';
                
                // Table Body
                html += '<tbody>';
                for (const row of report.tableData) {
                    html += '<tr>';
                    for (const value of row) {
                        html += `<td>${value}</td>`;
                    }
                    html += '</tr>';
                }
                html += '</tbody>';
                html += '</table>';
                html += '</div>';
                html += '</div>';
            }

            container.innerHTML = html;
            lucide.createIcons();

            // Render chart if data exists
            if (report.chartData) {
                renderChart(report.chartData);
            }
        }

        function renderChart(chartData) {
            const ctx = document.getElementById('trendChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: chartData.label || 'Value',
                        data: chartData.values,
                        borderColor: '#1e40af',
                        backgroundColor: 'rgba(30, 64, 175, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function formatLabel(key) {
            return key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        }

        function formatValue(key, value) {
            if (key.includes('amount') || key.includes('revenue') || key.includes('value')) {
                return '₱' + parseFloat(value).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            }
            if (typeof value === 'number') {
                return value.toLocaleString();
            }
            return value;
        }

        function showError(message) {
            const container = document.getElementById('reportContent');
            container.innerHTML = `
                <div class="error-state">
                    <i data-lucide="alert-circle"></i>
                    <p>${message}</p>
                    <button class="btn btn-primary" onclick="loadReportData()">Retry</button>
                </div>
            `;
            lucide.createIcons();
        }

        function downloadPDF() {
            const params = new URLSearchParams({
                type: reportType,
                start: startDate,
                end: endDate,
                group: groupBy
            });
            window.open(`../../api/admin/reports/generate-pdf.php?${params.toString()}`, '_blank');
        }
    </script>
</body>
</html>
