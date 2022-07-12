<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RSAController extends Controller
{
    public function generateKeysPairs()
    {
        // Save Private Key
        $privkey = openssl_pkey_new();
        openssl_pkey_export_to_file($privkey, public_path('test.pem'));
    }

    public function encrypt()
    {
        $data = 'Teacher Coca.';
        $valid = openssl_private_encrypt($data, $crypted, openssl_pkey_get_private(file_get_contents(public_path('private.pem'))), OPENSSL_PKCS1_PADDING);
        $data = base64_encode($crypted);
        if ($valid) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to encrypt.'
            ]);
        }
    }

    public function decrypt(Request $request)
    {
    }
}
