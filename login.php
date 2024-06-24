<?php
require_once(__DIR__ . '/includes/login-process.php');
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

    <!-- logo icon image/x-icon  -->
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/login.css">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <div class="container-fluid" id="login-page">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6 col-lg-5 mb-5">
                <div class="content text-center mb-5">
                    <img src="img/logo.png" alt="Logo" class="logo">
                    <p class="text-muted">SDOOC Panel</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="alert <?php echo isset($_SESSION['status_type']) ? ($_SESSION['status_type'] == 'error' ? 'alert-danger' : 'alert-success') : ''; ?>">
                    <?php
                    if(isset($_SESSION['status'])) {
                        echo "<h4>".htmlspecialchars($_SESSION['status'])."</h4>";
                        unset($_SESSION['status']);
                        unset($_SESSION['status_type']);
                    }
                    ?>
                </div>
                <div class="container-login p-4" id="login-form-container">
                    <div class="login-label">Login</div>
                    <form method="POST" id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCSRFToken()); ?>">
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input id="username" type="text" class="form-control" name="username" autocomplete="username" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control" name="password" autocomplete="current-password">
                                <div class="input-group-append">
                                    <span class="input-group-text toggle-password" onclick="togglePassword()">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-check d-flex justify-content-between align-items-center">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary py-2 px-4 w-50" style="border-radius: 6px;">Login</button>
                        </div>
                    </form>                                 
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once(__DIR__ . '/includes/sweetalert.php');
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Main JS -->
    <script src="js/toggle-password.js"></script>
    <script src="js/login.js"></script>
    <script src="js/sw-function.js"></script>
</body>
</html>