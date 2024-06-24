<?php
session_start();
require_once('connect.php');

// Function to generate a random AES-256 encryption key
function generateEncryptionKey() {
    if (function_exists('random_bytes')) {
        return random_bytes(32); // 256 bits
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        return openssl_random_pseudo_bytes(32); // 256 bits
    } else {
        throw new Exception('Random bytes generation not supported. Cannot proceed.');
    }
}

// Function to encrypt data using AES-256
function encryptData($data, $key) {
    $iv = random_bytes(16); // Initialization vector
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['editAppTitle'], $_POST['editAppDescription'], $_POST['editAppLink'], $_POST['editAppId'], $_POST['editAppColor'])) {
        // Sanitize and validate input data
        $appId = filter_input(INPUT_POST, 'editAppId', FILTER_VALIDATE_INT);
        $title = filter_input(INPUT_POST, 'editAppTitle', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'editAppDescription', FILTER_SANITIZE_STRING);
        $link = filter_var($_POST['editAppLink'], FILTER_VALIDATE_URL);
        $color = filter_input(INPUT_POST, 'editAppColor', FILTER_SANITIZE_STRING);
        $existingImagePath = filter_input(INPUT_POST, 'existingImagePath', FILTER_SANITIZE_STRING);

        // Generate a random encryption key for storing sensitive data
        $encryptionKey = generateEncryptionKey();

        // Encrypt sensitive data before storing it in the database
        $encryptedTitle = encryptData($title, $encryptionKey);
        $encryptedLink = encryptData($link, $encryptionKey);
        $encryptedColor = encryptData($color, $encryptionKey);

        if (!$encryptedLink) {
            $_SESSION['error_message'] = "Error: Invalid URL format.";
            header("Location: index.php");
            exit();
        }

        // Check if a new image file is uploaded
        if (isset($_FILES['editAppImage']) && $_FILES['editAppImage']['error'] === UPLOAD_ERR_OK) {
            // Process the uploaded image
            $imageTmpName = $_FILES['editAppImage']['tmp_name'];
            $imageFileName = basename($_FILES['editAppImage']['name']);
            $imageFileExt = pathinfo($imageFileName, PATHINFO_EXTENSION);
            $allowedExtensions = array("jpg", "jpeg", "png", "jfif", "webp", "avif");

            // Check if the file extension is allowed
            if (!in_array($imageFileExt, $allowedExtensions)) {
                $_SESSION['error_message'] = "Error: Invalid file extension. Allowed extensions are JPG, JPEG, and PNG.";
                header("Location: index.php");
                exit();
            }

            // Encrypt the path to the uploaded image
            $targetDir = "img/uploads/";
            $targetFilePath = $targetDir . $imageFileName;

            // Ensure unique file name by appending timestamp
            $targetFilePath = $targetDir . time() . '_' . $imageFileName;

            // Encrypt the new image path
            $encryptedImage = encryptData($targetFilePath, $encryptionKey);

            // Move the uploaded file to a permanent location
            move_uploaded_file($imageTmpName, $targetFilePath);

            // Remove the existing image file if it exists
            if (file_exists($existingImagePath) && $existingImagePath !== $targetFilePath) {
                unlink($existingImagePath);
            }
        } else {
            // If no new image uploaded, retain the existing encrypted image path
            $encryptedImage = encryptData($existingImagePath, $encryptionKey);
        }

        // Get the admin ID from the session
        $adminId = $_SESSION['admin_id'];

        // Check if the admin ID exists in the admin_tbl
        $stmtAdmin = $pdo->prepare('SELECT admin_id FROM admin_tbl WHERE admin_id = ?');
        $stmtAdmin->execute([$adminId]);
        $adminExists = $stmtAdmin->fetchColumn();
        
        if (!$adminExists) {
            $_SESSION['error_message'] = 'Invalid admin ID';
            header('Location: index.php', true, 400);
            exit();
        }

        // Update the application record in the database
        $stmt = $pdo->prepare('UPDATE application_tbl SET application_title = ?, application_description = ?, application_link = ?, application_color = ?, encryption_key = ?, application_image = ?, admin_id = ? WHERE application_id = ?');
        $stmt->execute([$encryptedTitle, $description, $encryptedLink, $encryptedColor, $encryptionKey, $encryptedImage, $adminId, $appId]);

        $_SESSION['success_message'] = "Application updated successfully";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Missing or invalid input data";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Error: Invalid request method";
    header("Location: index.php");
    exit();
}
?>