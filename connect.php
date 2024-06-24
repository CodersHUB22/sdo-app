<?php
require_once('config/config.php');

try {

    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);


    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $stmt = $pdo->query("SELECT CURRENT_DATE");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>