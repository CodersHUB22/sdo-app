<?php
session_start();
require_once('connect.php');

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $_SESSION['error_message'] = 'CSRF token validation failed.';
        header('Location: index.php', true, 403);
        exit();
    }

    if (isset($_POST['appTitle'], $_POST['appDescription'], $_POST['appLink'], $_FILES['appImage'], $_POST['appColor'])) {
        $title = sanitizeInput($_POST['appTitle']);
        $description = sanitizeInput($_POST['appDescription']);
        $link = filter_var($_POST['appLink'], FILTER_VALIDATE_URL);
        $color = sanitizeInput($_POST['appColor']);

        // Generate a random encryption key for storing sensitive data
        $encryptionKey = generateEncryptionKey();

        // Encrypt sensitive data before storing it in the database
        $encryptedTitle = encryptData($title, $encryptionKey);
        $encryptedLink = encryptData($link, $encryptionKey);
        $encryptedColor = encryptData($color, $encryptionKey);

        if (!$encryptedLink) {
            $_SESSION['error_message'] = 'Invalid URL';
            header('Location: index.php', true, 400);
            exit();
        }

        $image = $_FILES['appImage'];
        $check = getimagesize($image["tmp_name"]);
        if ($check === false) {
            $_SESSION['error_message'] = 'Invalid image file';
            header('Location: index.php', true, 400);
            exit();
        }

        // Move the uploaded image to the target directory
        $targetDir = "img/uploads/";
        $imageFileName = basename($image["name"]);
        $targetFile = $targetDir . $imageFileName;

        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            // Encrypt the path to the uploaded image
            $encryptedImage = encryptData($targetFile, $encryptionKey);
            $imageFileExt = pathinfo($imageFileName, PATHINFO_EXTENSION);
            $allowedExtensions = array("jpg", "jpeg", "png", "jfif", "webp", "avif");
            
            // Check if the file extension is allowed
            if (!in_array($imageFileExt, $allowedExtensions)) {
                $_SESSION['error_message'] = "Error: Invalid file extension. Allowed extensions are JPG, JPEG, and PNG.";
                header("Location: index.php");
                exit();
            }

            // You need to get the admin ID from the session or wherever it's stored
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

            $stmt = $pdo->prepare('INSERT INTO application_tbl (application_title, application_description, application_link, application_image, application_color, encryption_key, admin_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
            if ($stmt->execute([$encryptedTitle, $description, $encryptedLink, $encryptedImage, $encryptedColor, $encryptionKey, $adminId])) {
                $_SESSION['success_message'] = 'Application added successfully';
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['error_message'] = 'Failed to save application';
                header('Location: index.php', true, 500);
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Failed to upload image';
            header('Location: index.php', true, 500);
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Missing required fields';
        header('Location: index.php', true, 400);
        exit();
    }
} else {
    $_SESSION['error_message'] = 'Invalid request method';
    header('Location: index.php', true, 405);
    exit();
}
?>