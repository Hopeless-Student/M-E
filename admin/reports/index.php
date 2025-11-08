<?php
 require_once __DIR__ . '/../../auth/admin_auth.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailed Reports - M & E Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/M&E_LOGO-semi-transparent.ico">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="../assets/css/admin/reports/index.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="dashboard">
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" data-sidebar-toggle="open">
            <i data-lucide="menu"></i>
        </button>

        <?php include '../../includes/admin_sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <div class="header-left">
                    <h2>Detailed Reports</h2>
                    <p class="header-subtitle">Generate comprehensive business reports</p>
                </div>
                <div class="user-info">
                    <span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
                    <div class="avatar"><?= htmlspecialchars(strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1))) ?></div>
                </div>
            </div>

            <div class="breadcrumb">
                <a href="../index.php">Dashboard</a>
                <span>></span>
                <span>Reports</span>
            </div>

            <!-- Report Categories -->
            <div class="reports-grid">
                <!-- Sales Report -->
                <div class="report-card">
                    <div class="report-icon sales">
                        <i data-lucide="trending-up"></i>
                    </div>
                    <h3>Sales Report</h3>
                    <p>Comprehensive sales analysis with revenue breakdown, top products, and trends</p>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="generateReport('sales', 'view')">
                            <i data-lucide="eye"></i> View Report
                        </button>
                        <button class="btn btn-secondary" onclick="generateReport('sales', 'pdf')">
                            <i data-lucide="download"></i> Download PDF
                        </button>
                    </div>
                </div>

                <!-- Inventory Report -->
                <div class="report-card">
                    <div class="report-icon inventory">
                        <i data-lucide="package"></i>
                    </div>
                    <h3>Inventory Report</h3>
                    <p>Complete inventory status, stock levels, and valuation analysis</p>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="generateReport('inventory', 'view')">
                            <i data-lucide="eye"></i> View Report
                        </button>
                        <button class="btn btn-secondary" onclick="generateReport('inventory', 'pdf')">
                            <i data-lucide="download"></i> Download PDF
                        </button>
                    </div>
                </div>

                <!-- Customer Report -->
                <div class="report-card">
                    <div class="report-icon customers">
                        <i data-lucide="users"></i>
                    </div>
                    <h3>Customer Report</h3>
                    <p>Customer analytics, purchase behavior, and loyalty insights</p>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="generateReport('customers', 'view')">
                            <i data-lucide="eye"></i> View Report
                        </button>
                        <button class="btn btn-secondary" onclick="generateReport('customers', 'pdf')">
                            <i data-lucide="download"></i> Download PDF
                        </button>
                    </div>
                </div>

                <!-- Orders Report -->
                <div class="report-card">
                    <div class="report-icon orders">
                        <i data-lucide="shopping-cart"></i>
                    </div>
                    <h3>Orders Report</h3>
                    <p>Order statistics, fulfillment rates, and delivery performance</p>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="generateReport('orders', 'view')">
                            <i data-lucide="eye"></i> View Report
                        </button>
                        <button class="btn btn-secondary" onclick="generateReport('orders', 'pdf')">
                            <i data-lucide="download"></i> Download PDF
                        </button>
                    </div>
                </div>

                <!-- Financial Report -->
                <div class="report-card">
                    <div class="report-icon financial">
                        <i data-lucide="dollar-sign"></i>
                    </div>
                    <h3>Financial Report</h3>
                    <p>Revenue, expenses, profit margins, and financial performance</p>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="generateReport('financial', 'view')">
                            <i data-lucide="eye"></i> View Report
                        </button>
                        <button class="btn btn-secondary" onclick="generateReport('financial', 'pdf')">
                            <i data-lucide="download"></i> Download PDF
                        </button>
                    </div>
                </div>

                <!-- Custom Report -->
                <div class="report-card">
                    <div class="report-icon custom">
                        <i data-lucide="settings"></i>
                    </div>
                    <h3>Custom Report</h3>
                    <p>Build your own report with custom date ranges and filters</p>
                    <div class="report-actions">
                        <button class="btn btn-primary" onclick="openCustomReportModal()">
                            <i data-lucide="sliders"></i> Configure
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats-section">
                <h3>Report Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i data-lucide="file-text"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">Total Reports Generated</span>
                            <span class="stat-value" id="totalReports">-</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i data-lucide="calendar"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">Last Report</span>
                            <span class="stat-value" id="lastReport">-</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i data-lucide="download"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">Downloads This Month</span>
                            <span class="stat-value" id="monthlyDownloads">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Custom Report Modal -->
    <div class="modal-overlay" id="customReportModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Configure Custom Report</h3>
                <button class="modal-close" onclick="closeCustomReportModal()">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="customReportForm">
                    <div class="form-group">
                        <label class="form-label">Report Type</label>
                        <select class="form-select" id="customReportType" required>
                            <option value="">Select Type</option>
                            <option value="sales">Sales Analysis</option>
                            <option value="inventory">Inventory Analysis</option>
                            <option value="customers">Customer Analysis</option>
                            <option value="orders">Order Analysis</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-input" id="startDate" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-input" id="endDate" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Group By</label>
                        <select class="form-select" id="groupBy">
                            <option value="day">Daily</option>
                            <option value="week">Weekly</option>
                            <option value="month" selected>Monthly</option>
                            <option value="year">Yearly</option>
                        </select>
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeCustomReportModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            loadReportStats();
        });

        function generateReport(type, action) {
            if (action === 'view') {
                window.location.href = `view-report.php?type=${type}`;
            } else if (action === 'pdf') {
                showToast('Generating PDF report...', 'info');
                window.open(`../../api/admin/reports/generate-pdf.php?type=${type}`, '_blank');
            }
        }

        function openCustomReportModal() {
            document.getElementById('customReportModal').classList.add('active');
            lucide.createIcons();
        }

        function closeCustomReportModal() {
            document.getElementById('customReportModal').classList.remove('active');
        }

        document.getElementById('customReportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const type = document.getElementById('customReportType').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const groupBy = document.getElementById('groupBy').value;
            
            const params = new URLSearchParams({
                type: type,
                start: startDate,
                end: endDate,
                group: groupBy
            });
            
            window.location.href = `view-report.php?${params.toString()}`;
        });

        async function loadReportStats() {
            // Placeholder stats - you can implement actual tracking later
            document.getElementById('totalReports').textContent = '47';
            document.getElementById('lastReport').textContent = 'Today';
            document.getElementById('monthlyDownloads').textContent = '23';
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
</body>
</html>
