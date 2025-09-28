<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Movements - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.6;
        }

        .stock-movements-dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Main Content */
        .stock-movements-main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px; /* Adjust based on sidebar width */
        }

        .stock-movements-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1rem 1.5rem; /* Slightly reduced padding for compactness */
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .stock-movements-header h2 {
            font-size: 1.8rem; /* Slightly smaller for better proportion */
            font-weight: 600;
            color: #1e40af;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stock-movements-header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .stock-movements-back-btn {
            background: #64748b;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stock-movements-back-btn:hover {
            background: #475569;
            color: white;
        }

        .stock-movements-refresh-btn {
            background: #1e40af;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stock-movements-refresh-btn:hover {
            background: #1e3a8a;
        }

        .stock-movements-export-btn {
            background: #059669;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stock-movements-export-btn:hover {
            background: #047857;
        }

        .stock-movements-user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stock-movements-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Summary Cards */
        .stock-movements-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); /* Adjusted for better proportion */
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stock-movements-summary-card {
            background: white;
            padding: 1.5rem; /* Slightly reduced padding */
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
            text-align: center;
            position: relative;
        }

        .stock-movements-summary-card.add {
            border-left-color: #10b981;
        }

        .stock-movements-summary-card.remove {
            border-left-color: #ef4444;
        }

        .stock-movements-summary-card.adjust {
            border-left-color: #3b82f6;
        }

        .stock-movements-summary-card.net {
            border-left-color: #f59e0b;
        }

        .stock-movements-summary-title {
            font-size: 0.85rem; /* Slightly smaller for density */
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stock-movements-summary-value {
            font-size: 1.8rem; /* Slightly smaller */
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stock-movements-summary-card.add .stock-movements-summary-value {
            color: #10b981;
        }

        .stock-movements-summary-card.remove .stock-movements-summary-value {
            color: #ef4444;
        }

        .stock-movements-summary-card.adjust .stock-movements-summary-value {
            color: #3b82f6;
        }

        .stock-movements-summary-card.net .stock-movements-summary-value {
            color: #f59e0b;
        }

        .stock-movements-summary-subtitle {
            font-size: 0.8rem;
            color: #64748b;
        }

        .stock-movements-summary-icon {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            opacity: 0.3;
        }

        /* Controls/Filters */
        .stock-movements-controls {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .stock-movements-controls-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .stock-movements-filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .stock-movements-form-group {
            display: flex;
            flex-direction: column;
        }

        .stock-movements-form-label {
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .stock-movements-form-input, .stock-movements-form-select {
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

        .stock-movements-form-input:focus, .stock-movements-form-select:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .stock-movements-date-range {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .stock-movements-apply-btn {
            background: #1e40af;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            align-self: end;
            grid-column: 1 / -1;
        }

        .stock-movements-apply-btn:hover {
            background: #1e3a8a;
        }

        /* Movements Table */
        .stock-movements-table-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .stock-movements-table-container {
            overflow-x: auto;
        }

        .stock-movements-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px; /* Ensure horizontal scroll on small screens */
        }

        .stock-movements-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem; /* Slightly smaller for density */
            border-bottom: 2px solid #e2e8f0;
        }

        .stock-movements-table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .stock-movements-table tr:hover {
            background-color: #f8fafc;
        }

        .stock-movements-movement-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stock-movements-movement-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
        }

        .stock-movements-movement-icon.add {
            background: #10b981;
        }

        .stock-movements-movement-icon.remove {
            background: #ef4444;
        }

        .stock-movements-movement-icon.adjust {
            background: #3b82f6;
        }

        .stock-movements-movement-icon.transfer {
            background: #f59e0b;
        }

        .stock-movements-movement-details h4 {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .stock-movements-movement-details p {
            font-size: 0.8rem;
            color: #64748b;
        }

        .stock-movements-movement-type {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .stock-movements-movement-type.add {
            background: #dcfce7;
            color: #166534;
        }

        .stock-movements-movement-type.remove {
            background: #fee2e2;
            color: #991b1b;
        }

        .stock-movements-movement-type.adjust {
            background: #dbeafe;
            color: #1e40af;
        }

        .stock-movements-movement-type.transfer {
            background: #fef3c7;
            color: #92400e;
        }

        .stock-movements-quantity {
            font-weight: 700;
            font-size: 1rem;
        }

        .stock-movements-quantity.add {
            color: #10b981;
        }

        .stock-movements-quantity.remove {
            color: #ef4444;
        }

        .stock-movements-impact {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .stock-movements-impact.positive {
            background: #dcfce7;
            color: #166534;
        }

        .stock-movements-impact.negative {
            background: #fee2e2;
            color: #991b1b;
        }

        .stock-movements-actions {
            display: flex;
            gap: 0.5rem;
        }

        .stock-movements-action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .stock-movements-action-btn.view {
            background: #3b82f6;
            color: white;
        }

        .stock-movements-action-btn.view:hover {
            background: #2563eb;
        }

        .stock-movements-action-btn.reverse {
            background: #f59e0b;
            color: white;
        }

        .stock-movements-action-btn.reverse:hover {
            background: #d97706;
        }

        /* Pagination */
        .stock-movements-pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .stock-movements-pagination-info {
            color: #64748b;
            font-size: 0.85rem;
        }

        .stock-movements-pagination-controls {
            display: flex;
            gap: 0.5rem;
        }

        .stock-movements-page-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.85rem;
        }

        .stock-movements-page-btn:hover:not(:disabled) {
            background: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        .stock-movements-page-btn.active {
            background: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        .stock-movements-page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Modal Styles */
        .stock-movements-modal-base {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            animation: stockMovementsFadeIn 0.3s ease;
        }

        .stock-movements-modal-base.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        @keyframes stockMovementsFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .stock-movements-modal-content {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0
