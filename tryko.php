================================================================================
ERROR RESOLUTION GUIDE: "Unexpected token '<', is not valid JSON"
================================================================================

ERROR SUMMARY:
--------------
The JavaScript frontend is expecting JSON data from your PHP backend API, but
instead it's receiving HTML content (specifically PHP error output starting
with "<br /><b>").

This happens when your PHP script encounters an error BEFORE it can send the
JSON response, causing PHP to output an HTML-formatted error message instead.


ROOT CAUSE ANALYSIS:
--------------------
When you see this error pattern with "<br />" and "<b>" tags, it means:

1. Your API endpoint (in this case: templates/list.php or similar) is being
   called successfully (not a 404)

2. The PHP file is executing but encountering an error during execution

3. PHP's error reporting is outputting HTML-formatted error messages to the
   response stream

4. Your JavaScript's JSON.parse() tries to parse this HTML and fails


SPECIFIC TO YOUR CODE:
----------------------
The error occurs in this call chain:
- app.js line 1239: init() is called
- app.js line 26: init() calls loadTemplates()
- app.js line 109: loadTemplates() calls API.getTemplates()
- api.js line 168: getTemplates() calls this.call() with templatesUrl
- api.js line 37: JSON parsing fails, error is caught and logged

Your templatesUrl is defined as: '../../api/admin/requests/templates'

This means the JavaScript is trying to call PHP files in the templates directory.


COMMON CAUSES IN YOUR CODEBASE:
-------------------------------

1. MISSING config.php FILE
   Location: The PHP files have this line:
   require_once __DIR__ . '/../../../config/config.php';

   Problem: If config.php doesn't exist or the path is wrong, PHP will throw:
   "Fatal error: require_once(): Failed opening required 'config.php'"
   This outputs as HTML before any JSON can be sent.

2. DATABASE CONNECTION ERROR
   The config.php file likely contains PDO database connection code.
   If database credentials are wrong or the database server is down,
   PDO will throw an exception that outputs as HTML.

3. MISSING PHPMailer LIBRARY
   Files like adminResponse.php have:
   require_once __DIR__ . '/../vendor/autoload.php';

   If Composer dependencies aren't installed, this will fail.

4. PHP WARNINGS OR NOTICES
   Even minor PHP warnings (undefined variable, deprecated function, etc.)
   will output HTML text before the JSON response, breaking the JSON format.

5. SYNTAX ERRORS IN PHP FILES
   A syntax error in any of the template-related PHP files will output
   a PHP parse error as HTML.


STEP-BY-STEP DIAGNOSTIC PROCESS:
---------------------------------

STEP 1: ENABLE PHP ERROR LOGGING (CRITICAL)
--------------------------------------------
Instead of displaying errors (which breaks your JSON), log them to a file:

In your php.ini or at the top of config.php, add:
```
error_reporting(E_ALL);
ini_set('display_errors', 0);        // Don't display errors in output
ini_set('display_startup_errors', 0);
ini_set('log_errors', 1);            // Log errors to file
ini_set('error_log', '/path/to/your/php-errors.log'); // Set log file path
```

This will prevent HTML error output from breaking your JSON responses.


STEP 2: CHECK THE ACTUAL API RESPONSE
--------------------------------------
Open your browser's Developer Tools (F12):

1. Go to the Network tab
2. Reload your page to trigger the error
3. Find the request to the templates endpoint (look for "list.php" or similar)
4. Click on it and view the "Response" tab

You should see the ACTUAL HTML error message instead of just the JSON parse error.
This will tell you EXACTLY what PHP error is occurring.

Look for messages like:
- "Fatal error: require_once()"
- "Warning: PDO::__construct()"
- "Parse error: syntax error"
- "Notice: Undefined variable"


STEP 3: VERIFY FILE PATHS
--------------------------
Check if these files exist at the expected locations:

From your templates/list.php file (or similar), trace backwards:
- Does config/config.php exist 3 directories up?
- Does vendor/autoload.php exist for Composer dependencies?
- Are all the file paths correct relative to where PHP is executing from?

Note: The paths in require_once are relative to the CURRENT PHP file,
not the web root or document root.


STEP 4: CHECK DATABASE CONNECTION
----------------------------------
In your config.php file, verify:

1. Database credentials are correct:
   - Host (localhost or IP)
   - Database name
   - Username
   - Password
   - Port (usually 3306 for MySQL)

2. Wrap your PDO connection in a try-catch:
   ```
   try {
       $pdo = new PDO($dsn, $user, $pass, $options);
   } catch (PDOException $e) {
       error_log("Database connection failed: " . $e->getMessage());
       // Don't echo anything here - it will break JSON
       http_response_code(500);
       header('Content-Type: application/json');
       echo json_encode(['success' => false, 'error' => 'Database connection failed']);
       exit;
   }
   ```

3. Test database connection separately with a simple test script


STEP 5: VERIFY COMPOSER DEPENDENCIES
-------------------------------------
If you're using PHPMailer (which your code does), ensure Composer is set up:

1. Check if vendor/ directory exists in your project
2. Check if vendor/autoload.php exists
3. Check if vendor/phpmailer/ directory exists

If missing, run in your project root:
```
composer install
```

Or if you don't have a composer.json, install PHPMailer:
```
composer require phpmailer/phpmailer
```


STEP 6: CHECK FOR OUTPUT BEFORE JSON
-------------------------------------
Search ALL PHP files for any content BEFORE the <?php tag:

BAD:
```
 <?php    // Notice the space before <?php
```

Or:

```
<?php
echo "Debug message";  // This will break JSON
header('Content-Type: application/json');
```

GOOD:
```
<?php
header('Content-Type: application/json');
// Only JSON output after this point
```

Rule: NOTHING should be output before the JSON response, not even whitespace.


STEP 7: VERIFY TEMPLATE-SPECIFIC FILES
---------------------------------------
Check if these template management files exist and have correct paths:

1. api/admin/requests/templates/list.php (or list-2.php)
2. api/admin/requests/templates/create.php
3. api/admin/requests/templates/update.php (or update-2.php)
4. api/admin/requests/templates/delete.php
5. api/admin/requests/templates/use.php

If any are missing or in wrong locations, the JavaScript call will fail.


STEP 8: CHECK YOUR .htaccess OR WEB SERVER CONFIG
--------------------------------------------------
If you're using Apache with .htaccess:

1. Make sure .htaccess isn't rewriting the templates URL incorrectly
2. Check if PHP is properly configured to execute .php files
3. Verify the document root is set correctly

For Nginx, check your server block configuration.


RESOLUTION CHECKLIST:
---------------------
☐ Step 1: Enabled error logging, disabled display_errors
☐ Step 2: Checked Network tab to see actual PHP error
☐ Step 3: Verified all file paths and files exist
☐ Step 4: Tested database connection separately
☐ Step 5: Installed Composer dependencies
☐ Step 6: Removed any output before JSON response
☐ Step 7: Verified all template endpoint files exist
☐ Step 8: Checked web server configuration


TESTING THE FIX:
----------------
After making changes:

1. Clear browser cache and refresh (Ctrl+Shift+R)
2. Check Network tab - you should now see valid JSON response
3. Check your error log file for any new PHP errors
4. Monitor console - the error should be gone

If the error persists, repeat Step 2 to see what the NEW error is.


SIMILAR ERRORS IN YOUR CODE:
----------------------------
This SAME error pattern will occur in these other API calls:

1. api.js line 50: getRequests() calling list.php
2. api.js line 57: getRequest() calling get-single.php
3. api.js line 64: getStats() calling get-stats.php
4. api.js line 71: updateRequest() calling update.php
5. api.js line 81: sendResponse() calling send-response.php
6. api.js line 93-118: All archive-related endpoints

ALL of these endpoints could throw the same "<br /><b>" error if:
- config.php is missing or has wrong path
- Database connection fails
- Required files are missing
- PHP errors occur before JSON output


PREVENTION STRATEGY:
--------------------
To prevent this error in ALL your PHP API endpoints:

1. CREATE A COMMON ERROR HANDLER
   In config.php or a new error-handler.php file:
   ```
   // Set error handling
   error_reporting(E_ALL);
   ini_set('display_errors', 0);
   ini_set('log_errors', 1);
   ini_set('error_log', __DIR__ . '/php-errors.log');

   // Custom error handler for JSON APIs
   function jsonErrorHandler($errno, $errstr, $errfile, $errline) {
       error_log("PHP Error [$errno]: $errstr in $errfile:$errline");
       http_response_code(500);
       header('Content-Type: application/json');
       echo json_encode(['success' => false, 'error' => 'Internal server error']);
       exit;
   }

   set_error_handler('jsonErrorHandler');
   ```

2. WRAP ALL API ENDPOINTS IN TRY-CATCH
   Every PHP endpoint should have:
   ```
   try {
       // Your API logic here
   } catch (Exception $e) {
       error_log($e->getMessage());
       http_response_code(500);
       echo json_encode(['success' => false, 'error' => 'Server error']);
   }
   ```

3. VALIDATE CONFIG.PHP EXISTS
   At the top of each API file:
   ```
   $configPath = __DIR__ . '/../../../config/config.php';
   if (!file_exists($configPath)) {
       http_response_code(500);
       header('Content-Type: application/json');
       echo json_encode(['success' => false, 'error' => 'Configuration missing']);
       exit;
   }
   require_once $configPath;
   ```

4. TEST DATABASE BEFORE QUERIES
   After including config.php:
   ```
   if (!isset($pdo) || !($pdo instanceof PDO)) {
       http_response_code(500);
       header('Content-Type: application/json');
       echo json_encode(['success' => false, 'error' => 'Database unavailable']);
       exit;
   }
   ```


EXPECTED OUTCOME:
-----------------
After following these steps:

✓ No more HTML in JSON responses
✓ All errors logged to php-errors.log instead of displayed
✓ Clean JSON error responses when things go wrong
✓ Easier debugging through error logs
✓ More robust error handling across all endpoints


NEED MORE HELP?
---------------
If the error persists after following these steps:

1. Check the php-errors.log file - it will have the specific error
2. Check the Network tab Response - it will show the exact PHP error
3. Verify the file paths are correct for YOUR server setup
4. Make sure your web server (Apache/Nginx) is properly configured for PHP

The key is: Find out what the ACTUAL PHP error is (Step 2), then fix that
specific error. The JSON parse error is just a symptom, not the root cause.

================================================================================
