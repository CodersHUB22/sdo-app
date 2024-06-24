<?php
require_once(__DIR__ . '/includes/security.php');

function my_autoloader($class) {
    include __DIR__ . '/includes/' . strtolower($class) . '.php';
}

spl_autoload_register('my_autoloader');

$current_path = $_SERVER['REQUEST_URI'];
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark-blue">
    <div class="container-fluid d-flex justify-content-between">
        <button class="navbar-toggler d-lg-none" type="button" id="headerToggler" aria-label="Header Toggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav main-nav">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold <?= ($current_path === '/sdo-app/index.php' ? 'active' : ''); ?>" href="/sdo-app/index.php" id="all-categories">All Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="/sdo-app/web-app" id="web-app">Web Application</a>
                </li>
            </ul>
        </div>
        <?php if ($is_admin): ?>
            <div class="profile-container">
                <?php require_once __DIR__ . '/includes/admin-decryption.php'; ?>
                <div class="profile-img">
                    <img src="img/profile.png" alt="Profile Image">
                </div>
                <div class="profile-name"><?= htmlentities(isset($adminUsername) ? $adminUsername : 'Unknown', ENT_QUOTES, 'UTF-8') ?></div>
                <input type="hidden" class="profile-dropdown">
                <ul class="profile-dropdown-list">
                    <li class="profile-dropdown-list-info">
                        <div class="profile-img">
                            <img src="img/profile.png" alt="Profile Image">
                        </div>
                        <div class="profile-name"><?= htmlentities(isset($adminUsername) ? $adminUsername : 'Unknown', ENT_QUOTES, 'UTF-8') ?></div>
                    </li>
                    <hr>
                    <li class="profile-dropdown-list-item mobile-only" id="mobile-all-categories"><a class="<?= ($current_path === '/sdo-app/index.php' ? 'active' : ''); ?>" href="/sdo-app/index.php" id="mobile-all-categories">All Categories</a></li>
                    <li class="profile-dropdown-list-item mobile-only" id="mobile-web-app"><a href="/sdo-app/web-app" id="mobile-web-app">Web Application</a></li>
                    <li class="profile-dropdown-list-item"><a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <div class="profile-container desktop-hidden">
                <div class="menu">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <ul class="profile-dropdown-list">
                    <li class="profile-dropdown-list-item mobile-only" id="mobile-all-categories"><a class="<?= ($current_path === '/sdo-app/index.php' ? 'active' : ''); ?>" href="/sdo-app/index.php" id="mobile-all-categories">All Categories</a></li>
                    <li class="profile-dropdown-list-item mobile-only" id="mobile-web-app"><a href="/sdo-app/web-app" id="mobile-web-app">Web Application</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>