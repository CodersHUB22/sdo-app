<?php
session_start();
require_once('../connect.php');

// Function to generate a random AES-256 encryption key
function generateEncryptionKey()
{
    if (function_exists('random_bytes')) {
        return random_bytes(32); // 256 bits
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        return openssl_random_pseudo_bytes(32); // 256 bits
    } else {
        throw new Exception('Random bytes generation not supported. Cannot proceed.');
    }
}

// Function to encrypt data using AES-256
function encryptData($data, $key)
{
    $iv = random_bytes(16); // Initialization vector
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

$username = 'Admin';
$rawPassword = 'sdoadmin_1234';
$role = 'admin';

// Validate the password
if (!preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[_\W]).{8,}$/', $rawPassword)) {
    $_SESSION['error_message'] = "Password must contain at least 8 characters, including one letter, one number, and one special character (_ or non-alphanumeric character).";
    header("Location: ../login.php");
    exit;
}

try {
    // Hash the raw password
    $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

    // Generate a random encryption key for storing sensitive data
    $encryptionKey = generateEncryptionKey();

    // Encrypt the hashed password
    $encryptedPassword = encryptData($hashedPassword, $encryptionKey);

    // Insert the username, encrypted password, and encryption key into the database using prepared statements
    $stmt = $pdo->prepare("INSERT INTO admin_tbl (admin_username, admin_pass, admin_role, encryption_key) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $encryptedPassword, $role, $encryptionKey]);

    $_SESSION['success_message'] = "Data inserted successfully!";
    header("Location: ../login.php");
    exit;
} catch (PDOException $e) {
    // Handle database errors
    $_SESSION['error_message'] = "Error: " . $e->getMessage();
    header("Location: ../login.php");
    exit;
} catch (Exception $ex) {
    // Handle other errors
    $_SESSION['error_message'] = "Error: " . $ex->getMessage();
    header("Location: ../login.php");
    exit;
}
?>