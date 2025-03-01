<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат get_headers</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        main {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }
        textarea {
            width: 100%;
            height: 150px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <main>
        <textarea readonly>
<?php
session_start();

// Display form data
$username = $_SESSION['username'] ?? 'N/A';
$email = $_SESSION['email'] ?? 'N/A';
$type = $_SESSION['type'] ?? 'N/A';
$message = $_SESSION['message'] ?? 'N/A';
$response_type = $_SESSION['response_type'] ?? 'N/A';

// Display headers and form data
echo "Form Data:\n";
echo "Username: $username\n";
echo "Email: $email\n";
echo "Type: $type\n";
echo "Message: $message\n";
echo "Response Type: $response_type\n\n";

// Display headers
echo "Headers:\n";
$headers = getallheaders();
echo implode("\n", array_map(
    function($key, $value) { return "$key: $value"; },
    array_keys($headers),
    $headers
));
?>
        </textarea>
    </main>
</body>
</html>