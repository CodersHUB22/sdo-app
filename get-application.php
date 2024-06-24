<?php
require_once('connect.php');
session_start();

if (isset($_POST['appId'])) {
    // Sanitize the ID parameter to prevent SQL injection
    $appId = intval($_POST['appId']);

    // Retrieve application details
    $stmt = $pdo->prepare('SELECT * FROM application_tbl WHERE application_id = ?');
    $stmt->execute([$appId]);
    $application = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($application) {
        // Return application details as JSON response
        echo json_encode($application);
        exit();
    } else {
        // If application with given ID is not found, return an error message
        http_response_code(404);
        echo json_encode(['error' => 'Application not found']);
    }
} else {
    // If ID parameter is not provided, return an error message
    http_response_code(400);
    echo json_encode(['error' => 'ID parameter is missing']);
}
?>