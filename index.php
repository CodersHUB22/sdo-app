<?php
require_once(__DIR__ . '/includes/home-function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDOOC Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- logo icon image/x-icon  -->
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/home.css" />
    <link rel="stylesheet" href="css/menu.css" />
    <link rel="stylesheet" href="./css/masonry-layout.css">
    <link rel="stylesheet" href="./css/masonry.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <?php require_once(__DIR__ . '/header.php'); ?>
    <div class="container">
        <?php if ($is_admin): ?>
            <div class="d-flex">
                <button type="button" class="btn btn-primary text-white font-weight-bold py-2 px-4 shadow-sm bg-primary ml-auto mt-3" style="width: 200px; border-radius: 6px;" data-toggle="modal" data-target="#addApplicationModal" id="btnAdd">Add Application</button>
            </div>
        <?php endif;?>
        <main class="grid-container">
            <?php require_once(__DIR__ . '/fetch-data.php'); ?>
        </main>
        <?php if ($is_admin): ?>
            <!-- Modal for Add Application -->
            <div class="modal fade" id="addApplicationModal" tabindex="-1" aria-labelledby="addApplicationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addApplicationModalLabel">Add Application</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addApplicationForm" enctype="multipart/form-data" method="POST" action="add-application.php">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCSRFToken()); ?>">
                                <div class="form-group">
                                    <label for="appImage">Upload Image:</label>
                                    <input type="file" class="form-control-file" id="appImage" name="appImage" accept="image/png, image/jpeg, image/jpg" onchange="previewImage()">
                                    <div class="image-container">
                                        <img id="preview-image" class="preview-image img-fluid mx-auto" alt="Preview" src="img/white-background.jpg">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="appTitle">Title:</label>
                                    <input type="text" class="form-control" id="appTitle" name="appTitle" placeholder="Enter title">
                                </div>
                                <div class="form-group">
                                    <label for="appDescription">Description:</label>
                                    <textarea class="form-control" id="appDescription" name="appDescription" rows="5" placeholder="Enter description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="appLink">Reference Link:</label>
                                    <input type="url" class="form-control" id="appLink" name="appLink" placeholder="Enter reference link">
                                </div>
                                <div class="form-group color-picker">
                                    <label for="appColor">Pick a background color:</label>
                                    <input type="color" class="form-control" id="appColor" name="appColor" value="#000">
                                    <div class="color-label">
                                        <strong>Hex Code:</strong><span id="colorCode"></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif?>
    </div>
    <?php
    require_once(__DIR__ . '/includes/sweetalert.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
    <script src="./js/masonry-1.js"></script>
    <script src="./js/masonry-layout-vanilla.min.js"></script>
    <script src="js/header.js"></script>
    <script src="js/script.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/color.js"></script>
    <script src="js/upload.js"></script>
    <script src="js/edit-function.js"></script>
    <script src="js/delete-application.js"></script>
    <script src="js/admin-logout.js"></script>
    <script src="js/sw-function.js"></script>
</body>
</html>