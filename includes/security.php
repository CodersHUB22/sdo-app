<?php
// Function to decrypt data using AES-256
function decryptData($data, $key)
{
    $data = base64_decode($data);
    
    // Extract the IV and encrypted data
    $iv = substr($data, 0, 16);
    $encryptedData = substr($data, 16);

    // Pad the IV if it's less than 16 bytes
    if (strlen($iv) < 16) {
        $iv = str_pad($iv, 16, "\0");
    }

    // Decrypt the data
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}
?>