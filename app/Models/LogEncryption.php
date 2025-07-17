<?php
namespace App\Models;

class LogEncryption
{
    private $key = 'your-secret-key'; // N?n l?u ? bi?n m?i tr??ng th?c t?

    public function encryptSensitiveData($data)
    {
        return openssl_encrypt(json_encode($data), 'AES-128-ECB', $this->key);
    }

    public function decryptSensitiveData($encryptedData)
    {
        return json_decode(openssl_decrypt($encryptedData, 'AES-128-ECB', $this->key), true);
    }

    private function getSensitiveFields()
    {
        return ['error_message', 'old_data', 'new_data'];
    }

    private function getEncryptionKey()
    {
        return $this->key;
    }
}
