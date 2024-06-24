<?php
session_start();

// Check if admin is already logged out
if (!isset($_SESSION['logged_out'])) {
    // Clear specific session variables
    unset($_SESSION['admin_id']);
    unset($_SESSION['username']);

    // Clear all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Regenerate CSRF token to prevent token reuse
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Clear the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Set the logged_out flag
    $_SESSION['logged_out'] = true;
}

// Redirect to login page after logout
header("Location: login.php");
exit();
?>