<?php
session_start();
require_once('connect.php');
require_once('includes/security.php');

// Function to generate a CSRF token
function generateCSRFToken() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}

// Function to validate the CSRF token
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Function to validate the password strength
function validatePasswordStrength($password) {
    // Password must be at least 8 characters long, include at least one letter, one number, and one special character
    return preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[\W_]).{8,}$/', $password);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $_SESSION['error_message'] = 'CSRF token validation failed';
        header("Location: login.php");
        exit;
    }

    // Initialize variables
    $username = $password = '';

    // Sanitize and validate input data
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = sanitizeInput($_POST["username"]);
        $password = $_POST["password"];
    } else {
        // Return validation errors
        $_SESSION['status'] = "Username and password are required";
        $_SESSION['status_type'] = "error";
        header("Location: login.php");
        exit;
    }

    // Validate password strength
    if (!validatePasswordStrength($password)) {
        $_SESSION['status'] = "Password must contain at least 8 characters, including one letter, one number, and one special character";
        $_SESSION['status_type'] = "error";
        header("Location: login.php");
        exit;
    }

    // Get admin ID and role
    $adminID = '1';
    $adminRole = 'admin';

    // Prepare and execute query to find admin by ID, username, and role
    $stmt = $pdo->prepare("SELECT * FROM admin_tbl WHERE admin_id = ? AND admin_username = ? AND admin_role = ?");
    $stmt->execute([$adminID, $username, $adminRole]);
    $adminData = $stmt->fetch();

    // Perform login if admin data is found
    if ($adminData) {
        // Decrypt the stored password using the encryption key retrieved from the database
        $encryptionKey = $adminData['encryption_key'];
        $decryptedPassword = decryptData($adminData['admin_pass'], $encryptionKey);

        if ($adminRole && password_verify($password, $decryptedPassword)) {
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Store session data securely
            $_SESSION['admin_id'] = $adminID;
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_role'] = $adminRole;
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['status'] = "Invalid password";
            $_SESSION['status_type'] = "error";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['status'] = "Admin not found";
        $_SESSION['status_type'] = "error";
        header("Location: login.php");
        exit;
    }
}
?>