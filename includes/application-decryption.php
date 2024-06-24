<?php
$encryptionKey1 = $application['encryption_key'];
$title = decryptData($application['application_title'], $encryptionKey1);
$description = decryptData($application['application_description'], $encryptionKey1);
$link = decryptData($application['application_link'], $encryptionKey1);
$color = decryptData($application['application_color'], $encryptionKey1);
$image = decryptData($application['application_image'], $encryptionKey1);
$directory = 'img/uploads/';
$path = $directory . $image;
?>