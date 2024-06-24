<?php
require_once('connect.php');
session_start();

if (isset($_GET['id'])) {
    // Sanitize and validate the application ID
    $applicationId = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if ($applicationId !== false && $applicationId > 0) {
        // Delete the application record from the database
        $stmt = $pdo->prepare('DELETE FROM application_tbl WHERE application_id = ?');
        $stmt->execute([$applicationId]);

        // Check if the application was deleted successfully
        if ($stmt->rowCount() > 0) {
            $_SESSION['success_message'] = "Application deleted successfully";
        } else {
            $_SESSION['error_message'] = "Error: Application not found.";
        }
    } else {
        $_SESSION['error_message'] = "Error: Invalid application ID.";
    }
} else {
    $_SESSION['error_message'] = "Error: Missing application ID.";
}

header("Location: index.php");
exit();
?>