<?php
require_once('connect.php'); // Include your database connection script

// Function to generate a CSRF token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Function to validate the CSRF token
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Function to check if the user is assigned as the admin for managing application data
function isAdminForApplication($adminId, $applicationId, $pdo) {
    $stmt = $pdo->prepare('SELECT COUNT(*) AS count FROM application_tbl WHERE application_id = ? AND admin_id = ?');
    $stmt->execute([$applicationId, $adminId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}

// Prepare and execute a parameterized query to retrieve application data
$stmt = $pdo->prepare('SELECT * FROM application_tbl ORDER BY application_id DESC');
$stmt->execute();
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// HTML output
if (count($applications) == 0) {
    echo '
    <div class="container alert-message">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                    <strong>No results found!</strong>
                </div>
            </div>
        </div>
    </div>';
} else {
    echo '<div class="wrapper-masonry">';
    require_once('includes/security.php');
    foreach ($applications as $index => $item) {
        $applicationId = $item['application_id'];
        $applicationTitle = htmlspecialchars(decryptData($item['application_title'], $item['encryption_key']));
        $applicationDescription = nl2br(htmlspecialchars($item['application_description']));
        $applicationLink = htmlspecialchars(decryptData($item['application_link'], $item['encryption_key']));
        $applicationColor = htmlspecialchars(decryptData($item['application_color'], $item['encryption_key']));
        $applicationImage = htmlspecialchars(decryptData($item['application_image'], $item['encryption_key']));
        $directory = 'img/uploads/';
        $path = $directory . basename($applicationImage);

        // Determine card type (horizontal or vertical based on index)
        $cardTypeClass = '';
        switch ($index % 8) {
            case 0: $cardTypeClass = 'grid-item-span1'; break; // Horizontal
            case 1: $cardTypeClass = 'grid-item-span2'; break; // Vertical
            case 2: $cardTypeClass = 'grid-item-span3'; break; // Horizontal
            case 3: $cardTypeClass = 'grid-item-span4'; break; // Vertical
            case 4: $cardTypeClass = 'grid-item-span5'; break; // Horizontal
            case 5: $cardTypeClass = 'grid-item-span6'; break; // Vertical
            case 6: $cardTypeClass = 'grid-item-span7'; break; // Horizontal
            case 7: $cardTypeClass = 'grid-item-span8'; break; // Vertical
            default: $cardTypeClass = 'grid-item-span1'; break;
        }

        echo '<div class="grid-cards ' . $cardTypeClass . '" style="background-color: ' . $applicationColor . ';">
        <a href="' . $applicationLink . '" target="_blank">  
            <img src="' . $path . '" alt="' . $applicationTitle . '">
            <h4 class="card-title">' . htmlspecialchars($applicationTitle) . '</h4>
            <p>' . htmlspecialchars($applicationDescription) . '</p>
        </a>';
        // Check if the user is an admin and assigned for managing this application data
        if (isset($_SESSION['admin_id']) && isAdminForApplication($_SESSION['admin_id'], $applicationId, $pdo)) {
            echo '<div class="card-footer">
                    <div class="btn-container">
                        <a href="#" role="button" class="edit-button" data-toggle="modal" data-target="#editModal' . $applicationId . '">Edit</a>
                        <a href="#" role="button" class="delete-button" data-application-id="' . $applicationId . '">Delete</a>
                    </div>
                </div>';
        }
        echo '</div>';

        // Output the edit modal for each card
        echo '
        <div class="modal fade" id="editModal' . $applicationId . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $applicationId . '" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel' . $applicationId . '">Edit Application</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" method="POST" action="edit-application.php">
                            <input type="hidden" name="csrf_token" value="' . generateCSRFToken() . '">
                            <input type="hidden" name="editAppId" value="' . $applicationId . '">
                            <input type="hidden" name="existingImagePath" value="' . $path . '">
                            <div class="form-group">
                                <label for="editAppImage' . $applicationId . '">Upload Image</label>
                                <input type="file" class="form-control-file" id="editAppImage' . $applicationId . '" name="editAppImage" accept="image/png, image/jpeg, image/jpg" onchange="previewEditImage(' . $applicationId . ')">
                                <div class="image-container" id="preview-edit-image-container-' . $applicationId . '">
                                    <img id="preview-edit-image-' . $applicationId . '" class="preview-image img-fluid mx-auto" alt="Preview" src="' . $path . '">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="editAppTitle">Title</label>
                                <input type="text" class="form-control" id="editAppTitle" name="editAppTitle" placeholder="Enter title" value="' . htmlspecialchars($applicationTitle) . '">
                            </div>
                            <div class="form-group">
                                <label for="editAppDescription">Description</label>
                                <textarea class="form-control" id="editAppDescription" name="editAppDescription" rows="5" placeholder="Enter description">' . htmlspecialchars($applicationDescription) . '</textarea>
                            </div>
                            <div class="form-group">
                                <label for="editAppLink">Reference Link</label>
                                <input type="url" class="form-control" id="editAppLink" name="editAppLink" placeholder="Enter reference link" value="' . $applicationLink . '">
                            </div>
                            <div class="form-group">
                                <label for="editAppColor' . $applicationId . '" id="colorSelector">Pick a Background Color:</label>
                                <input type="color" class="form-control" id="editAppColor' . $applicationId . '" name="editAppColor" value="' . $applicationColor . '">
                                <div class="color-label">
                                    <strong>Hex Code:</strong><span id="colorCode' . $applicationId . '">' . $applicationColor . '</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="submitEditBtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }
    echo '</div>';
}
?>