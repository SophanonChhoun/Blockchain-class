<?php

namespace App\Core;

class EncryptLib
{
    private static $key;

    public static function encryptString($plaintext, $key = null, $iv = null)
    {
        self::setKeyAndIv($key, $iv);
        $ciphertext = openssl_encrypt($plaintext, "DES-EDE3", self::$key, OPENSSL_RAW_DATA);

        return base64_encode($ciphertext);
    }

    public static function decryptString($ciphertext, $key = null, $iv = null)
    {
        self::setKeyAndIv($key, $iv);
        $str = openssl_decrypt(base64_decode($ciphertext), 'DES-EDE3', self::$key, OPENSSL_RAW_DATA);
        return $str;
    }

    protected static function setKeyAndIv($key, $iv)
    {
        if ($key) {
            self::$key =  $key;
        } else {
            self::$key =  "1234567890123456";
        }
    }
}
