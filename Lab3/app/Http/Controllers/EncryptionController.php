<?php

namespace App\Http\Controllers;

use App\Core\EncryptLib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EncryptionController extends Controller
{
    public function encrypt()
    {
        $plaintext = "This is a plaintext string";
        $ciphertext = EncryptLib::encryptString($plaintext);

        return response()->json([
            'success' => true,
            'data' => $ciphertext
        ]);
    }

    public function decrypt(Request $request)
    {
        $ciphertext = $request->ciphertext;
        $plaintext = EncryptLib::decryptString($ciphertext);
        $file = time() . rand() . '_file.txt';
        $destinationPath = public_path() . "/upload/";
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        File::put($destinationPath . $file, $plaintext);
        return response()->json([
            'success' => true,
            'message' => 'Success decrypt.'
        ]);
    }

    public function encryptFile()
    {
        $file = Storage::disk('local')->get('bros_sart.jpeg');
        $ciphertext = EncryptLib::encryptString($file);
        return response()->json([
            'success' => true,
            'data' => $ciphertext
        ]);
    }

    public function decryptFile(Request $request)
    {
        $ciphertext = $request->ciphertext;
        $plaintext = EncryptLib::decryptString($ciphertext);
        $file = time() . rand() . '_file.jpeg';
        $destinationPath = public_path() . "/upload/";
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        File::put($destinationPath . $file, $plaintext);
        return response()->json([
            'success' => true,
            'message' => 'Success decrypt.'
        ]);
    }
}
