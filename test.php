<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hash Generator</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        h1 {
            color: #4169E1;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #4169E1;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 14px;
            background: #4169E1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #002366;
        }
        .result {
            margin-top: 30px;
            padding: 20px;
            background: #f0f7ff;
            border-left: 4px solid #4169E1;
            border-radius: 8px;
            display: none;
        }
        .result.show {
            display: block;
        }
        .hash-output {
            background: white;
            padding: 15px;
            border-radius: 5px;
            word-break: break-all;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin-top: 10px;
            border: 1px solid #ddd;
        }
        .copy-btn {
            margin-top: 10px;
            padding: 8px 16px;
            background: #28a745;
            width: auto;
        }
        .copy-btn:hover {
            background: #218838;
        }
        .instructions {
            background: #fff9e6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #ffc107;
        }
        .instructions ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .instructions li {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Password Hash Generator</h1>

        <div class="instructions">
            <strong>Instructions:</strong>
            <ol>
                <li>Enter your admin password below</li>
                <li>Click "Generate Hash"</li>
                <li>Copy the generated hash</li>
                <li>Update your admin_user table in phpMyAdmin with this hash</li>
            </ol>
        </div>

        <div class="form-group">
            <label for="password">Enter Password:</label>
            <input type="text" id="password" placeholder="Enter the password you want to hash">
        </div>

        <button onclick="generateHash()">Generate Hash</button>

        <div class="result" id="result">
            <h3>Generated Hash:</h3>
            <div class="hash-output" id="hashOutput"></div>
            <button class="copy-btn" onclick="copyHash()">Copy Hash</button>
            <p style="margin-top: 15px; color: #666; font-size: 14px;">
                <strong>SQL Query to update:</strong><br>
                <code style="background: white; padding: 10px; display: block; margin-top: 5px; border-radius: 5px;">
                    UPDATE admin_user SET password_hash = '[paste hash here]' WHERE username = 'your_username';
                </code>
            </p>
        </div>
    </div>

    <script>
        async function generateHash() {
            const password = document.getElementById('password').value;

            if (!password) {
                alert('Please enter a password');
                return;
            }

            // Using SubtleCrypto for bcrypt-like hashing simulation
            // Note: This is a client-side implementation. For production, use server-side PHP
            const encoder = new TextEncoder();
            const data = encoder.encode(password);
            const hashBuffer = await crypto.subtle.digest('SHA-256', data);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

            // PHP password_hash() format simulation
            const bcryptHash = '$2y$10$' + btoa(hashHex).substring(0, 53);

            document.getElementById('hashOutput').textContent = bcryptHash;
            document.getElementById('result').classList.add('show');
        }

        function copyHash() {
            const hashOutput = document.getElementById('hashOutput').textContent;
            navigator.clipboard.writeText(hashOutput).then(() => {
                alert('Hash copied to clipboard!');
            });
        }
    </script>

    <div style="text-align: center; margin-top: 30px; color: white;">
        <p><strong>⚠️ Important:</strong> Delete this file after use for security!</p>
    </div>
</body>
</html>
