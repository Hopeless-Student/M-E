/**
 * API Helper Functions for Customer Request Management
 * All API calls centralized here for easy maintenance
 */

const API = {
    baseUrl: '../../api/admin/requests',
    templatesUrl: '../../api/admin/requests/templates',

    async call(url, options = {}) {
    try {
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                ...options.headers
            },
            ...options
        });

        const contentType = response.headers.get('content-type');
        let data;

        if (contentType && contentType.includes('application/json')) {
            data = await response.json();
        } else {
            const text = await response.text();
            console.error('Non-JSON response:', text);
            throw new Error(`Invalid JSON response: ${text.substring(0, 100)}...`);
        }

        if (!response.ok) {
            throw new Error(data.error || data.message || 'API request failed');
        }

        return data;
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}
,

    // ============ REQUESTS API ============

    /**
     * Get list of requests with filters
     */
    async getRequests(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return await this.call(`${this.baseUrl}/list.php?${queryString}`);
    },

    /**
     * Get single request details
     */
    async getRequest(id, archived = false) {
        return await this.call(`${this.baseUrl}/get-single.php?id=${id}&archived=${archived}`);
    },

    /**
     * Get dashboard statistics
     */
    async getStats() {
        return await this.call(`${this.baseUrl}/get-stats.php`);
    },

    /**
     * Update request status
     */
    async updateRequest(id, status, adminResponse = '') {
        return await this.call(`${this.baseUrl}/update.php`, {
            method: 'POST',
            body: JSON.stringify({ id, status, adminResponse })
        });
    },

    /**
     * Send response to customer
     */
    async sendResponse(requestId, response, subject = '', status = 'in-progress', priority = 'normal') {
        return await this.call(`${this.baseUrl}/send-response.php`, {
            method: 'POST',
            body: JSON.stringify({ requestId, response, subject, status, priority })
        });
    },

    // ============ ARCHIVE API ============

    /**
     * Archive a request
     */
    async archiveRequest(requestId, reason, notes = '') {
        return await this.call(`${this.baseUrl}/archive.php`, {
            method: 'POST',
            body: JSON.stringify({ action: 'archive', requestId, reason, notes })
        });
    },

    /**
     * Bulk archive requests
     */
    async bulkArchiveRequests(requestIds, reason, notes = '') {
        return await this.call(`${this.baseUrl}/archive.php`, {
            method: 'POST',
            body: JSON.stringify({ action: 'bulk-archive', requestIds, reason, notes })
        });
    },

    /**
     * Restore archived request
     */
    async restoreRequest(archiveId) {
        return await this.call(`${this.baseUrl}/archive.php`, {
            method: 'POST',
            body: JSON.stringify({ action: 'restore', archiveId })
        });
    },

    /**
     * Bulk restore archived requests
     */
    async bulkRestoreRequests(archiveIds) {
        return await this.call(`${this.baseUrl}/archive.php`, {
            method: 'POST',
            body: JSON.stringify({ action: 'bulk-restore', archiveIds })
        });
    },

    /**
     * Delete archived request permanently
     */
    async deleteArchived(archiveId) {
        return await this.call(`${this.baseUrl}/archive.php`, {
            method: 'POST',
            body: JSON.stringify({ action: 'delete', archiveId })
        });
    },

    /**
     * Bulk delete archived requests
     */
    async bulkDeleteArchived(archiveIds) {
        return await this.call(`${this.baseUrl}/archive.php`, {
            method: 'POST',
            body: JSON.stringify({ action: 'bulk-delete', archiveIds })
        });
    },

    /**
     * List archived requests
     */
    async listArchived(params = {}) {
        return await this.call(`${this.baseUrl}/archive.php`, {
            method: 'POST',
            body: JSON.stringify({ action: 'list', ...params })
        });
    },

    // ============ TEMPLATES API ============

    /**
     * Get list of templates
     */
    async getTemplates(category = '', q = '') {
        const params = new URLSearchParams();
        if (category) params.append('category', category);
        if (q) params.append('q', q);
        return await this.call(`${this.templatesUrl}/list.php?${params.toString()}`);
    },

    /**
     * Create new template
     */
    async createTemplate(name, category, subject, content, notes = '') {
        return await this.call(`${this.templatesUrl}/create.php`, {
            method: 'POST',
            body: JSON.stringify({ name, category, subject, content, notes })
        });
    },

    /**
     * Update template
     */
    async updateTemplate(templateId, name, category, subject, content, notes = '') {
        return await this.call(`${this.templatesUrl}/update.php`, {
            method: 'POST',
            body: JSON.stringify({ templateId, name, category, subject, content, notes })
        });
    },

    /**
     * Delete template
     */
    async deleteTemplate(templateId) {
        return await this.call(`${this.templatesUrl}/delete.php`, {
            method: 'POST',
            body: JSON.stringify({ templateId })
        });
    },

    /**
     * Use template (increments usage count)
     */
    async useTemplate(templateId, variables = {}) {
        return await this.call(`${this.templatesUrl}/use.php`, {
            method: 'POST',
            body: JSON.stringify({ templateId, variables })
        });
    }
};
