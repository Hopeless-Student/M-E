<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M & E Interior Supplies Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="./assets/css/admin/index.css">
</head>
<body>
    <div class="dashboard">
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" data-sidebar-toggle="open">
            <i data-lucide="menu"></i>
        </button>

        <!-- Include Sidebar -->
        <?php include '../includes/admin_sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Dashboard Overview</h2>
                <div class="user-info">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid" id="statsGrid">
                <div class="loading">Loading dashboard data...</div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="./orders/index.php" class="action-card">
                    <div class="action-icon">
                        <i data-lucide="plus"></i>
                    </div>
                    <h4>New Order</h4>
                    <p>Create manual order</p>
                </a>
                <a href="./products/index.php" class="action-card">
                    <div class="action-icon">
                        <i data-lucide="package-plus"></i>
                    </div>
                    <h4>Add Product</h4>
                    <p>Add new product</p>
                </a>
                <a href="./inventory/index.php" class="action-card">
                    <div class="action-icon">
                        <i data-lucide="truck"></i>
                    </div>
                    <h4>Restock</h4>
                    <p>Update inventory</p>
                </a>
                <a href="./reports/index.php" class="action-card">
                    <div class="action-icon">
                        <i data-lucide="file-text"></i>
                    </div>
                    <h4>Reports</h4>
                    <p>View detailed reports</p>
                </a>
            </div>

            <!-- Charts -->
            <div class="charts-grid">
                <div class="chart-container">
                    <div class="chart-title">
                        <i data-lucide="trending-up"></i>
                        Sales & Orders (Last 6 Months)
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
                <div class="chart-container">
                    <div class="chart-title">
                        <i data-lucide="pie-chart"></i>
                        Product Categories
                    </div>
                    <div class="chart-wrapper small">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Order Status Distribution -->
            <div class="charts-grid">
                <div class="chart-container full-width">
                    <div class="chart-title">
                        <i data-lucide="activity"></i>
                        Order Status Distribution (Last 30 Days)
                    </div>
                    <div class="chart-wrapper small">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="orders-section">
                <div class="orders-header">
                    <h3 class="orders-title">
                        <i data-lucide="clock"></i>
                        Recent Orders
                    </h3>
                    <a href="../admin/orders/index.php" class="view-all">View All Orders</a>
                </div>
                <div class="table-container">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Category</th>
                                <th>Items</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTableBody">
                            <tr>
                                <td colspan="7" class="loading">Loading recent orders...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
          lucide.createIcons();

          let salesChart, categoryChart, statusChart;

          // Load dashboard data on page load
          document.addEventListener('DOMContentLoaded', function() {
              loadDashboardData();
          });

          async function loadDashboardData() {
              try {
                  // Simulate API call with sample data
                  const result = {
                      success: true,
                      data: {
                          stats: {
                              total_revenue: '145,250.00',
                              revenue_change: '12.5',
                              active_customers: '89',
                              customers_change: '5.2',
                              avg_order_value: '620.30'
                          },
                          charts: {
                              sales: {
                                  labels: ['April', 'May', 'June', 'July', 'August', 'September'],
                                  revenue: [85000, 92000, 88000, 105000, 125000, 145000],
                                  orders: [145, 160, 142, 175, 198, 234]
                              },
                              categories: {
                                  labels: ['Sanitary Supplies', 'Office Supplies', 'School Supplies'],
                                  data: [45, 35, 20]
                              },
                              order_status: {
                                  labels: ['Pending', 'Confirmed', 'Processing', 'Shipped', 'Delivered'],
                                  data: [7, 15, 12, 8, 25],
                                  colors: ['#f59e0b', '#1d4ed8', '#3730a3', '#5b21b6', '#059669']
                              }
                          },
                          recent_orders: [
                              {
                                  order_number: 'ORD-2024-001',
                                  customer_name: 'John Doe',
                                  category: 'Sanitary Supplies',
                                  item_count: '3',
                                  amount: '15,250.00',
                                  date: '2024-09-20',
                                  status: 'processing'
                              },
                              {
                                  order_number: 'ORD-2024-002',
                                  customer_name: 'Jane Smith',
                                  category: 'Office Supplies',
                                  item_count: '5',
                                  amount: '8,450.00',
                                  date: '2024-09-19',
                                  status: 'confirmed'
                              },
                              {
                                  order_number: 'ORD-2024-003',
                                  customer_name: 'Mike Johnson',
                                  category: 'School Supplies',
                                  item_count: '2',
                                  amount: '12,800.00',
                                  date: '2024-09-18',
                                  status: 'delivered'
                              },
                              {
                                  order_number: 'ORD-2024-004',
                                  customer_name: 'Sarah Wilson',
                                  category: 'Sanitary Supplies',
                                  item_count: '4',
                                  amount: '22,150.00',
                                  date: '2024-09-17',
                                  status: 'shipped'
                              },
                              {
                                  order_number: 'ORD-2024-005',
                                  customer_name: 'David Brown',
                                  category: 'Office Supplies',
                                  item_count: '1',
                                  amount: '3,200.00',
                                  date: '2024-09-16',
                                  status: 'pending'
                              }
                          ]
                      }
                  };

                  renderStats(result.data.stats);
                  renderCharts(result.data.charts);
                  renderRecentOrders(result.data.recent_orders);
              } catch (error) {
                  console.error('Error loading dashboard data:', error);
                  showError('Error loading dashboard data. Please check your connection.');
              }
          }

          function renderStats(stats) {
              const statsGrid = document.getElementById('statsGrid');

              const revenueChange = parseFloat(stats.revenue_change || 0);
              const customersChange = parseFloat(stats.customers_change || 0);

              const revenueChangeClass = revenueChange >= 0 ? 'positive' : 'negative';
              const customersChangeClass = customersChange >= 0 ? 'positive' : 'negative';

              const revenueChangeIcon = revenueChange >= 0 ? '' : '';
              const customersChangeIcon = customersChange >= 0 ? '' : '';

              statsGrid.innerHTML = `
                  <div class="stat-card">
                      <div class="stat-header">
                          <div class="stat-title">Total Revenue</div>
                          <i data-lucide="dollar-sign" class="stat-icon"></i>
                      </div>
                      <div class="stat-value">${stats.total_revenue}</div>
                      <div class="stat-change ${revenueChangeClass}">
                          ${revenueChangeIcon} ${Math.abs(revenueChange)}% from last month
                      </div>
                  </div>
                  <div class="stat-card">
                      <div class="stat-header">
                          <div class="stat-title">Average Order Value</div>
                          <i data-lucide="calculator" class="stat-icon"></i>
                      </div>
                      <div class="stat-value">${stats.avg_order_value}</div>
                      <div class="stat-change neutral">
                          Including shipping fees
                      </div>
                  </div>
                  <div class="stat-card">
                      <div class="stat-header">
                          <div class="stat-title">Active Customers</div>
                          <i data-lucide="users" class="stat-icon"></i>
                      </div>
                      <div class="stat-value">${stats.active_customers}</div>
                      <div class="stat-change ${customersChangeClass}">
                          ${customersChangeIcon} ${Math.abs(customersChange)}% this month
                      </div>
                  </div>
              `;

              // Re-initialize icons for new content
              lucide.createIcons();
          }

          function renderCharts(chartData) {
              // Sales & Orders Chart (Combined)
              const salesCtx = document.getElementById('salesChart').getContext('2d');
              if (salesChart) salesChart.destroy();

              salesChart = new Chart(salesCtx, {
                  type: 'line',
                  data: {
                      labels: chartData.sales.labels,
                      datasets: [
                          {
                              label: 'Revenue',
                              data: chartData.sales.revenue,
                              borderColor: '#1e40af',
                              backgroundColor: 'rgba(30, 64, 175, 0.1)',
                              borderWidth: 3,
                              fill: true,
                              tension: 0.4,
                              yAxisID: 'y'
                          },
                          {
                              label: 'Orders',
                              data: chartData.sales.orders,
                              borderColor: '#f59e0b',
                              backgroundColor: 'rgba(245, 158, 11, 0.1)',
                              borderWidth: 2,
                              fill: false,
                              tension: 0.4,
                              yAxisID: 'y1'
                          }
                      ]
                  },
                  options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      interaction: {
                          mode: 'index',
                          intersect: false
                      },
                      scales: {
                          x: {
                              display: true,
                              title: {
                                  display: true,
                                  text: 'Month'
                              }
                          },
                          y: {
                              type: 'linear',
                              display: true,
                              position: 'left',
                              title: {
                                  display: true,
                                  text: 'Revenue'
                              },
                              ticks: {
                                  callback: function(value) {
                                      return value.toLocaleString();
                                  }
                              }
                          },
                          y1: {
                              type: 'linear',
                              display: true,
                              position: 'right',
                              title: {
                                  display: true,
                                  text: 'Orders'
                              },
                              grid: {
                                  drawOnChartArea: false
                              }
                          }
                      }
                  }
              });

              // Category Chart
              const categoryCtx = document.getElementById('categoryChart').getContext('2d');
              if (categoryChart) categoryChart.destroy();

              categoryChart = new Chart(categoryCtx, {
                  type: 'doughnut',
                  data: {
                      labels: chartData.categories.labels,
                      datasets: [{
                          data: chartData.categories.data,
                          backgroundColor: [
                              '#1e40af',
                              '#f59e0b',
                              '#10b981'
                          ],
                          borderWidth: 0
                      }]
                  },
                  options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      plugins: {
                          legend: {
                              position: 'bottom',
                              labels: {
                                  padding: 20,
                                  usePointStyle: true
                              }
                          }
                      }
                  }
              });

              // Order Status Chart
              if (chartData.order_status && chartData.order_status.labels.length > 0) {
                  const statusCtx = document.getElementById('statusChart').getContext('2d');
                  if (statusChart) statusChart.destroy();

                  statusChart = new Chart(statusCtx, {
                      type: 'bar',
                      data: {
                          labels: chartData.order_status.labels,
                          datasets: [{
                              label: 'Orders',
                              data: chartData.order_status.data,
                              backgroundColor: chartData.order_status.colors,
                              borderWidth: 0
                          }]
                      },
                      options: {
                          responsive: true,
                          maintainAspectRatio: false,
                          plugins: {
                              legend: {
                                  display: false
                              }
                          },
                          scales: {
                              y: {
                                  beginAtZero: true,
                                  ticks: {
                                      stepSize: 1
                                  }
                              }
                          }
                      }
                  });
              }
          }

          function renderRecentOrders(orders) {
              const tableBody = document.getElementById('ordersTableBody');

              if (orders.length === 0) {
                  tableBody.innerHTML = '<tr><td colspan="7" class="loading">No recent orders found</td></tr>';
                  return;
              }

              tableBody.innerHTML = orders.map(order => `
                  <tr>
                      <td><strong>${order.order_number}</strong></td>
                      <td>${order.customer_name}</td>
                      <td><span class="category-badge">${order.category}</span></td>
                      <td>${order.item_count} item${order.item_count !== '1' ? 's' : ''}</td>
                      <td><strong>${order.amount}</strong></td>
                      <td>${order.date}</td>
                      <td><span class="status ${order.status}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></td>
                  </tr>
              `).join('');
          }

          function showError(message) {
              const statsGrid = document.getElementById('statsGrid');
              statsGrid.innerHTML = `<div class="error">${message}</div>`;
          }

          // Auto-refresh data every 5 minutes
          setInterval(loadDashboardData, 300000);
    </script>
</body>
</html>
