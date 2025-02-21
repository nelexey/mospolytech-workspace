<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $message = $_POST['message'];
    $response_type = isset($_POST['response_type']) ? $_POST['response_type'] : 'none';

    // Store data locally (e.g., in a file or database)
    $data = "Username: $username\nEmail: $email\nType: $type\nMessage: $message\nResponse Type: $response_type\n";
    file_put_contents('feedback.txt', $data, FILE_APPEND);

    // Store form data in session variables
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['type'] = $type;
    $_SESSION['message'] = $message;
    $_SESSION['response_type'] = $response_type;

    // Redirect to the second page
    header('Location: page2.php');
    exit();
}
?> 