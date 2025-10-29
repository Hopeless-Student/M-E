<style>
    /* General Modal Styles (to be shared across modals) */
    .app-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .app-modal-overlay.active {
        display: flex;
    }

    .app-modal {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        max-width: 700px; /* Increased max-width for better content display */
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .app-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .app-modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e40af;
    }

    .app-modal-close-btn {
        border: none;
        background: none;
        font-size: 1.8rem;
        cursor: pointer;
        color: #64748b;
        line-height: 1;
        padding: 0.2rem 0.5rem;
        border-radius: 6px;
        transition: background-color 0.2s ease;
    }
    .app-modal-close-btn:hover {
        background-color: #f0f4f8;
    }

    .app-modal-body {
        flex-grow: 1;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .app-modal-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    /* Form Group Styles (for modals) */
    .app-form-group {
        margin-bottom: 1.5rem;
    }

    .app-form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #374151;
        font-size: 0.95rem;
    }

    .app-form-input, .app-form-select, .app-form-textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-family: inherit;
        font-size: 0.9rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .app-form-input:focus, .app-form-select:focus, .app-form-textarea:focus {
        outline: none;
        border-color: #1e40af;
        box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.2);
    }

    .app-form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* Action Button Styles (for modals) */
    .app-action-btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    .app-action-btn.primary {
        background-color: #1e40af;
        color: white;
    }

    .app-action-btn.primary:hover {
        background-color: #1e3a8a;
    }

    .app-action-btn.secondary {
        background-color: #e2e8f0;
        color: #64748b;
    }

    .app-action-btn.secondary:hover {
        background-color: #cbd5e1;
    }

    .app-action-btn.danger {
        background-color: #dc2626;
        color: white;
    }

    .app-action-btn.danger:hover {
        background-color: #b91c1c;
    }

    /* Specific styles for the main page's modals */
    #archiveModal .app-modal, #responseModal .app-modal {
        max-width: 600px;
    }
    #archiveModal .app-modal-title, #responseModal .app-modal-title {
        font-size: 1.25rem;
    }

    /* Notification styles */
    .app-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background-color: #10b981;
        color: white;
        border-radius: 8px;
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
        z-index: 1001;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 250px;
        text-align: center;
    }

    .app-notification.show {
        transform: translateX(0);
    }

    .app-notification.error {
        background-color: #dc2626;
    }
    .app-notification.info {
        background-color: #2563eb;
    }

    /* Sidebar specific styles for active link */
    .nav-menu .nav-item .nav-link.active {
        background-color: rgba(255, 255, 255, 0.1);
        border-left-color: #60a5fa;
    }

    /* Archive Modal Specific Styles */
    #archiveModal .app-modal {
        max-width: 900px; /* Wider for table content */
    }
    #archiveModal .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    #archiveModal .stat-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
    }
    #archiveModal .stat-title {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }
    #archiveModal .stat-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e40af;
    }
    #archiveModal .archive-controls {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    #archiveModal .controls-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    #archiveModal .controls-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
    }
    #archiveModal .filter-controls {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    #archiveModal .archive-list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    #archiveModal .list-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #374151;
    }
    #archiveModal .bulk-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    #archiveModal .bulk-btn {
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background-color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: #374151;
        transition: background-color 0.2s ease;
    }
    #archiveModal .bulk-btn:hover:not(:disabled) {
        background-color: #f0f4f8;
    }
    #archiveModal .bulk-btn.danger {
        background-color: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }
    #archiveModal .bulk-btn.danger:hover:not(:disabled) {
        background-color: #fecaca;
    }
    #archiveModal .bulk-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    #archiveModal .archive-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
    }
    #archiveModal .archive-table th, #archiveModal .archive-table td {
        padding: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
    }
    #archiveModal .archive-table th {
        background-color: #f8fafc;
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
    }
    #archiveModal .archive-table td {
        font-size: 0.9rem;
        color: #374151;
    }
    #archiveModal .checkbox-cell {
        width: 30px;
        text-align: center;
    }
    #archiveModal .message-cell {
        min-width: 250px;
    }
    #archiveModal .message-from {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    #archiveModal .message-subject {
        color: #1e40af;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    #archiveModal .message-preview {
        font-size: 0.8rem;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }
    #archiveModal .message-type {
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }
    #archiveModal .message-type.inquiry { background-color: #dbeafe; color: #1d4ed8; }
    #archiveModal .message-type.custom-order { background-color: #fef3c7; color: #92400e; }
    #archiveModal .message-type.complaint { background-color: #fee2e2; color: #dc2626; }
    #archiveModal .message-type.feedback { background-color: #d1fae5; color: #065f46; }
    #archiveModal .action-cell {
        width: 120px;
        text-align: center;
    }
    #archiveModal .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }
    #archiveModal .icon-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.4rem;
        border-radius: 4px;
        transition: background-color 0.2s ease;
        color: #64748b;
    }
    #archiveModal .icon-btn:hover {
        background-color: #e2e8f0;
    }
    #archiveModal .icon-btn.danger {
        color: #dc2626;
    }
    #archiveModal .icon-btn.danger:hover {
        background-color: #fee2e2;
    }
    #archiveModal .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }
    #archiveModal .pagination-btn {
        padding: 0.5rem 0.8rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background-color: white;
        cursor: pointer;
        font-size: 0.85rem;
        color: #374151;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }
    #archiveModal .pagination-btn:hover:not(:disabled) {
        background-color: #f0f4f8;
        border-color: #a7b3c4;
    }
    #archiveModal .pagination-btn.active {
        background-color: #1e40af;
        color: white;
        border-color: #1e40af;
    }
    #archiveModal .pagination-btn.active:hover {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
    }
    #archiveModal .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* View Details Modal Specific Styles */
    #viewDetailsModal .app-modal {
        max-width: 1000px; /* Even wider for detailed view */
        padding: 0; /* Remove padding from modal itself, content will add it */
    }
    #viewDetailsModal .app-modal-body {
        padding: 0; /* Remove padding from modal body, content will add it */
    }

    /* Templates Modal Specific Styles */
    #templatesModal .app-modal {
        max-width: 1100px; /* Wider for template layout */
    }
    #templatesModal .template-layout {
        display: flex;
        gap: 1.5rem;
        min-height: 500px; /* Ensure some height for layout */
    }
    #templatesModal .template-categories {
        flex: 0 0 250px; /* Fixed width for categories */
        background-color: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
    }
    #templatesModal .categories-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    #templatesModal .categories-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
    }
    #templatesModal .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
        overflow-y: auto;
    }
    #templatesModal .category-item {
        margin-bottom: 0.5rem;
    }
    #templatesModal .category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        color: #475569;
        transition: background-color 0.2s ease, color 0.2s ease;
    }
    #templatesModal .category-link:hover {
        background-color: #e2e8f0;
    }
    #templatesModal .category-link.active {
        background-color: #1e40af;
        color: white;
    }
    #templatesModal .category-link.active .category-info svg {
        color: white;
    }
    #templatesModal .category-link.active .category-count {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }
    #templatesModal .category-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
    }
    #templatesModal .category-info svg {
        color: #64748b;
        transition: color 0.2s ease;
    }
    #templatesModal .category-count {
        padding: 0.2rem 0.6rem;
        background-color: #cbd5e1;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569;
    }

    #templatesModal .template-panel {
        flex: 1;
        background-color: white;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
    }
    #templatesModal .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
        flex-wrap: wrap;
    }
    #templatesModal .panel-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #374151;
    }
    #templatesModal .panel-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }
    #templatesModal .search-box {
        position: relative;
        display: flex;
        align-items: center;
    }
    #templatesModal .search-box .search-icon {
        position: absolute;
        left: 10px;
        color: #94a3b8;
    }
    #templatesModal .search-box .search-input {
        padding-left: 35px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        padding: 0.6rem 1rem 0.6rem 35px;
        font-size: 0.9rem;
        width: 200px;
    }
    #templatesModal .view-toggle {
        display: flex;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        overflow: hidden;
    }
    #templatesModal .toggle-btn {
        background-color: white;
        border: none;
        padding: 0.6rem 0.8rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
        color: #64748b;
    }
    #templatesModal .toggle-btn:hover {
        background-color: #f0f4f8;
    }
    #templatesModal .toggle-btn.active {
        background-color: #1e40af;
        color: white;
    }
    #templatesModal .templates-container {
        flex-grow: 1;
        overflow-y: auto;
    }
    #templatesModal .template-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    #templatesModal .template-grid.list-view {
        display: block; /* Override grid for list view */
    }
    #templatesModal .template-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1.2rem;
        background-color: #f8fafc;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s ease;
    }
    #templatesModal .template-grid.list-view .template-card {
        margin-bottom: 1rem;
    }
    #templatesModal .template-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    #templatesModal .template-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    #templatesModal .template-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e40af;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem; /* For wrapping */
    }
    #templatesModal .usage-badge {
        background-color: #dbeafe;
        color: #1d4ed8;
        padding: 0.2rem 0.6rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    #templatesModal .template-meta {
        font-size: 0.8rem;
        color: #64748b;
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem; /* For wrapping */
    }
    #templatesModal .template-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    #templatesModal .template-preview {
        font-size: 0.9rem;
        color: #475569;
        line-height: 1.5;
        margin-bottom: 1.5rem;
        max-height: 100px; /* Limit preview height */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 4; /* Limit to 4 lines */
        -webkit-box-orient: vertical;
    }
    #templatesModal .template-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: auto; /* Push actions to bottom */
    }
    #templatesModal .template-btn {
        padding: 0.6rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: background-color 0.2s ease, border-color 0.2s ease;
        font-size: 0.85rem;
        border: 1px solid #d1d5db;
        background-color: white;
        color: #374151;
    }
    #templatesModal .template-btn.primary {
        background-color: #1e40af;
        color: white;
        border-color: #1e40af;
    }
    #templatesModal .template-btn.primary:hover {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
    }
    #templatesModal .template-btn:hover:not(.primary) {
        background-color: #f0f4f8;
    }

    /* Template Editor/Usage Modal specific styles */
    #templateModal .template-variables, #useTemplateModal .template-variables {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    #templateModal .variables-title, #useTemplateModal .variables-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.75rem;
    }
    #templateModal .variables-list, #useTemplateModal .variables-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    #templateModal .variable-tag, #useTemplateModal .variable-tag {
        background-color: #e0e7ff;
        color: #3f51b5;
        padding: 0.4rem 0.8rem;
        border-radius: 16px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    #templateModal .variable-tag:hover, #useTemplateModal .variable-tag:hover {
        background-color: #c7d2fe;
    }

    @media (max-width: 900px) {
        #templatesModal .template-layout {
            flex-direction: column;
        }
        #templatesModal .template-categories {
            flex: none;
            width: 100%;
        }
        #templatesModal .panel-header {
            flex-direction: column;
            align-items: flex-start;
        }
        #templatesModal .panel-actions {
            margin-top: 1rem;
            width: 100%;
            justify-content: space-between;
        }
        #templatesModal .search-box .search-input {
            width: 100%;
        }
    }
</style>
