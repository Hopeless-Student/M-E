# Settings Module Testing Checklist

## Pre-Testing Setup

### 1. Database Setup
- [ ] Run setup script: `http://localhost/M-E/admin/settings/setup.php`
- [ ] Verify all tables created successfully
- [ ] Check default settings are inserted
- [ ] Confirm backup directory exists

### 2. Admin Login
- [ ] Login to admin dashboard
- [ ] Verify admin session is active
- [ ] Navigate to Settings page

## Functional Testing

### Business Information Section

**Test Case 1: Load Business Settings**
- [ ] Navigate to Settings > Business Info
- [ ] Verify all fields are populated with default values
- [ ] Check that form inputs are editable

**Test Case 2: Update Business Settings**
- [ ] Modify business name
- [ ] Update contact email
- [ ] Change contact phone
- [ ] Edit business address
- [ ] Update business description
- [ ] Click "Save Changes"
- [ ] Verify success toast notification appears
- [ ] Refresh page and confirm changes persist

**Test Case 3: Validation**
- [ ] Clear required fields and save
- [ ] Verify appropriate error messages
- [ ] Test invalid email format
- [ ] Verify validation feedback

---

### Shipping & Delivery Section

**Test Case 4: Load Shipping Settings**
- [ ] Navigate to Settings > Shipping & Delivery
- [ ] Verify delivery area is populated
- [ ] Check delivery fees are displayed
- [ ] Confirm processing/delivery times are shown

**Test Case 5: Update Shipping Settings**
- [ ] Change primary delivery area
- [ ] Update standard delivery fee
- [ ] Modify extended area fee
- [ ] Change processing time
- [ ] Update delivery time
- [ ] Toggle auto-confirm checkbox
- [ ] Click "Save Shipping Settings"
- [ ] Verify success notification
- [ ] Refresh and confirm persistence

**Test Case 6: Numeric Validation**
- [ ] Enter negative numbers in fee fields
- [ ] Enter non-numeric values
- [ ] Verify validation works correctly

---

### Notifications Section

**Test Case 7: Load Notification Settings**
- [ ] Navigate to Settings > Notifications
- [ ] Verify all checkboxes are displayed
- [ ] Check default states match database

**Test Case 8: Update Notification Settings**
- [ ] Toggle "New orders received"
- [ ] Toggle "Low stock alerts"
- [ ] Toggle "New customer messages"
- [ ] Toggle "Order status updates"
- [ ] Toggle "Daily sales reports"
- [ ] Click "Save Notification Settings"
- [ ] Verify success notification
- [ ] Refresh and confirm states persist

---

### User Management Section

**Test Case 9: Load Admin Account**
- [ ] Navigate to Settings > User Management
- [ ] Verify username is displayed
- [ ] Verify email is displayed
- [ ] Check password fields are empty

**Test Case 10: Update Username**
- [ ] Change username to new value
- [ ] Click "Update Account"
- [ ] Verify success notification
- [ ] Check header username updates
- [ ] Refresh page and confirm change

**Test Case 11: Update Email**
- [ ] Change email to new valid email
- [ ] Click "Update Account"
- [ ] Verify success notification
- [ ] Refresh and confirm change

**Test Case 12: Update Password**
- [ ] Enter new password (6+ characters)
- [ ] Enter matching confirm password
- [ ] Click "Update Account"
- [ ] Verify success notification
- [ ] Verify password fields are cleared
- [ ] Logout and login with new password

**Test Case 13: Password Validation**
- [ ] Enter password less than 6 characters
- [ ] Verify error message
- [ ] Enter mismatched passwords
- [ ] Verify error message
- [ ] Leave password empty but fill confirm
- [ ] Verify appropriate handling

**Test Case 14: Email Validation**
- [ ] Enter invalid email format
- [ ] Verify error message
- [ ] Enter email without @ symbol
- [ ] Verify validation

**Test Case 15: Username Uniqueness**
- [ ] Try to use existing admin username (if multiple admins)
- [ ] Verify error message about username taken

---

### Security Section

**Test Case 16: Load Security Settings**
- [ ] Navigate to Settings > Security
- [ ] Verify session timeout dropdown is populated
- [ ] Check "Remember Me" checkbox state
- [ ] Verify "Log admin activities" checkbox state

**Test Case 17: Update Security Settings**
- [ ] Change session timeout to different value
- [ ] Toggle "Remember Me" option
- [ ] Toggle "Log admin activities"
- [ ] Click "Save Security Settings"
- [ ] Verify success notification
- [ ] Refresh and confirm changes

---

### Backup & Data Section

**Test Case 18: Load Backup Settings**
- [ ] Navigate to Settings > Backup & Data
- [ ] Verify backup frequency dropdown
- [ ] Check last backup date field

**Test Case 19: Create Manual Backup**
- [ ] Click "Create Backup Now"
- [ ] Verify loading overlay appears
- [ ] Wait for completion
- [ ] Verify success notification
- [ ] Check last backup date updates
- [ ] Navigate to `/database/backups/` folder
- [ ] Verify backup file exists with timestamp
- [ ] Check file size is reasonable (> 0 bytes)

**Test Case 20: Update Backup Frequency**
- [ ] Change auto backup frequency
- [ ] Click save (if separate button)
- [ ] Verify success notification

**Test Case 21: Export Orders Data**
- [ ] Click "Export Orders Data"
- [ ] Verify CSV file downloads
- [ ] Open CSV and verify data format
- [ ] Check all expected columns present
- [ ] Verify data is accurate

**Test Case 22: Export Customer Data**
- [ ] Click "Export Customer Data"
- [ ] Verify CSV file downloads
- [ ] Open and verify data

**Test Case 23: Export Product Data**
- [ ] Click "Export Product Data"
- [ ] Verify CSV file downloads
- [ ] Open and verify data

**Test Case 24: Export Inventory Report**
- [ ] Click "Export Inventory Report"
- [ ] Verify CSV file downloads
- [ ] Open and verify data

**Test Case 25: Danger Zone**
- [ ] Click "Reset All Data"
- [ ] Verify confirmation dialog appears
- [ ] Click Cancel
- [ ] Verify nothing happens
- [ ] Click "Reset All Data" again
- [ ] Click OK
- [ ] Verify appropriate message (should show warning)

---

## API Endpoint Testing

### GET Endpoints

**Test Case 26: Get All Settings**
```
GET http://localhost/M-E/api/admin/settings/get.php?type=all
```
- [ ] Returns 200 status
- [ ] Returns JSON with success: true
- [ ] Contains all setting categories
- [ ] Data structure is correct

**Test Case 27: Get Specific Category**
```
GET http://localhost/M-E/api/admin/settings/get.php?type=business
```
- [ ] Returns 200 status
- [ ] Returns only business settings
- [ ] Data is correctly formatted

**Test Case 28: Get Admin Account**
```
GET http://localhost/M-E/api/admin/settings/get-account.php
```
- [ ] Returns 200 status
- [ ] Returns admin username and email
- [ ] Does not return password

### POST Endpoints

**Test Case 29: Update Settings**
```
POST http://localhost/M-E/api/admin/settings/update.php
Body: {
  "category": "business",
  "settings": {
    "business_name": "Test Business"
  }
}
```
- [ ] Returns 200 status
- [ ] Returns success: true
- [ ] Setting is updated in database

**Test Case 30: Update Admin Account**
```
POST http://localhost/M-E/api/admin/settings/update-account.php
Body: {
  "username": "testadmin",
  "email": "test@example.com"
}
```
- [ ] Returns 200 status
- [ ] Account is updated
- [ ] Session is updated

**Test Case 31: Create Backup**
```
POST http://localhost/M-E/api/admin/settings/backup.php
```
- [ ] Returns 200 status
- [ ] Backup file is created
- [ ] Returns backup info

**Test Case 32: Export Data**
```
GET http://localhost/M-E/api/admin/settings/export.php?type=orders
```
- [ ] Returns CSV file
- [ ] Correct Content-Type header
- [ ] File downloads properly

---

## Security Testing

**Test Case 33: Unauthorized Access**
- [ ] Logout from admin
- [ ] Try to access settings page directly
- [ ] Verify redirect to login
- [ ] Try to access API endpoints without session
- [ ] Verify 401 Unauthorized response

**Test Case 34: SQL Injection Prevention**
- [ ] Try SQL injection in text fields
- [ ] Verify inputs are sanitized
- [ ] Check database for malicious data

**Test Case 35: XSS Prevention**
- [ ] Enter `<script>alert('XSS')</script>` in text fields
- [ ] Save and reload
- [ ] Verify script doesn't execute
- [ ] Check data is properly escaped

---

## Performance Testing

**Test Case 36: Page Load Time**
- [ ] Measure initial page load
- [ ] Should load within 2 seconds
- [ ] Check for console errors

**Test Case 37: API Response Time**
- [ ] Measure API response times
- [ ] GET requests should respond < 500ms
- [ ] POST requests should respond < 1s

**Test Case 38: Large Data Export**
- [ ] Export large dataset (1000+ records)
- [ ] Verify export completes successfully
- [ ] Check file integrity

---

## Browser Compatibility

**Test Case 39: Chrome**
- [ ] All features work correctly
- [ ] UI renders properly
- [ ] No console errors

**Test Case 40: Firefox**
- [ ] All features work correctly
- [ ] UI renders properly
- [ ] No console errors

**Test Case 41: Edge**
- [ ] All features work correctly
- [ ] UI renders properly
- [ ] No console errors

---

## Error Handling

**Test Case 42: Database Connection Error**
- [ ] Temporarily break database connection
- [ ] Try to load settings
- [ ] Verify appropriate error message

**Test Case 43: Invalid JSON Input**
- [ ] Send malformed JSON to API
- [ ] Verify 400 Bad Request response

**Test Case 44: Missing Required Fields**
- [ ] Send incomplete data to API
- [ ] Verify validation error response

---

## UI/UX Testing

**Test Case 45: Navigation**
- [ ] Click each settings menu item
- [ ] Verify correct section displays
- [ ] Check active state highlights correctly

**Test Case 46: Toast Notifications**
- [ ] Verify success toasts are green
- [ ] Verify error toasts are red
- [ ] Check toasts auto-dismiss after 3 seconds
- [ ] Verify toast messages are clear

**Test Case 47: Loading States**
- [ ] Verify loading overlay appears during saves
- [ ] Check loading overlay disappears after completion
- [ ] Verify buttons are disabled during loading

**Test Case 48: Responsive Design**
- [ ] Test on mobile viewport (375px)
- [ ] Test on tablet viewport (768px)
- [ ] Test on desktop viewport (1920px)
- [ ] Verify all elements are accessible

---

## Regression Testing

After any code changes, re-run:
- [ ] Test Cases 1-10 (Core functionality)
- [ ] Test Cases 19-24 (Backup and export)
- [ ] Test Cases 33-35 (Security)

---

## Sign-Off

**Tester Name:** ___________________
**Date:** ___________________
**Version Tested:** ___________________

**Overall Result:**
- [ ] All tests passed
- [ ] Tests passed with minor issues (documented below)
- [ ] Tests failed (critical issues documented below)

**Issues Found:**
_______________________________________________________
_______________________________________________________
_______________________________________________________

**Notes:**
_______________________________________________________
_______________________________________________________
_______________________________________________________
