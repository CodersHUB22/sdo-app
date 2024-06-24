<?php
session_start();
require_once('connect.php');

// Fetch admin details if the user is an admin
$is_admin = false;
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    $stmt = $pdo->prepare("SELECT * FROM admin_tbl WHERE admin_id = ?");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $is_admin = !empty($admin);
}

// Check if admin is logged out
if (!$is_admin && isset($_SESSION['logged_out'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Validate user agent to prevent session hijacking
if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    // Destroy session data and redirect to login page
    session_unset();
    session_destroy();
    $_SESSION['status'] = "Session hijacking attempt detected. Please log in again";
    $_SESSION['status_type'] = "error";
    header("Location: login.php");
    exit();
}

// Update last activity time and user agent
$_SESSION['last_activity'] = time();
$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

// Store last activity time for JavaScript usage
echo '<input type="hidden" id="lastActivityTime" value="' . htmlspecialchars($_SESSION['last_activity']) . '" />';
?>