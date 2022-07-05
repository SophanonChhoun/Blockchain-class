<?php

function indexOfChar($char)
{
    // Get the index of the first occurrence of the character
    return array_search($char, listAlphabetic());
}

function charOfIndex($index)
{
    // Get the character at the index
    $chars = listAlphabetic();
    return $chars[$index];
}

function listAlphabetic()
{
    // Get the list of alphabetic characters
    return ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
}

function encryptCaesar($text, $key)
{
    // Encrypt the text using the Caesar cipher
    $result = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $number_of_text = indexOfChar($text[$i]) + $key;
        if ($number_of_text > count(listAlphabetic())) {
            $number_of_text -= count(listAlphabetic());
        }
        $result .= charOfIndex($number_of_text % count(listAlphabetic()));
    }

    return $result;
}

function decryptCaesar($text, $key)
{
    // Decrypt the text using the Caesar cipher
    $result = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $number_of_text = indexOfChar($text[$i]) - $key;
        if ($number_of_text < 0) {
            $number_of_text += count(listAlphabetic());
        }
        $result .= charOfIndex($number_of_text % count(listAlphabetic()));
    }

    return $result;
}

function encryptPolyalphabetic($text, $key)
{
    // Encrypt the text using the Polyalphabetic cipher
    $result = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $number_of_text = indexOfChar($text[$i]) + indexOfChar($key[$i]);
        if ($number_of_text > count(listAlphabetic())) {
            $number_of_text -= count(listAlphabetic());
        }

        $result .= charOfIndex($number_of_text % count(listAlphabetic()));
    }

    return $result;
}

function decryptPolyalphabetic($text, $key)
{
    // Decrypt the text using the Polyalphabetic cipher
    $result = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $number_of_text = indexOfChar($text[$i]) - indexOfChar($key[$i]);
        if ($number_of_text < 0) {
            $number_of_text += count(listAlphabetic());
        }

        $result .= charOfIndex($number_of_text % count(listAlphabetic()));
    }

    return $result;
}

function generateString($n)
{
    // Generate a random string of length $n
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, count(listAlphabetic()) - 1);
        $randomString .= charOfIndex($index);
    }

    return $randomString;
}

function readKey($name, $text)
{
    // Read the key from the file
    $myfile = fopen($name, "r") or die("Unable to open file!");
    $key = fread($myfile, filesize($name));
    fclose($myfile);
    if (strlen($key) < strlen($text)) {
        $finalKey = strlen($key);
        $i = 0;
        while (strlen($key) < strlen($text)) {
            $key .= $key[$i];
            $i++;
            if ($i >= $finalKey) {
                $i = 0;
            }
        }
        return $key;
    }
    return substr($key, 0, strlen($text));
}

function encryptOneTimePad($text)
{
    // Encrypt the text using the One-Time Pad cipher
    $result = "";
    $key = readKey("file.txt", $text);

    for ($i = 0; $i < strlen($text); $i++) {
        $number_of_text = indexOfChar($text[$i]) + indexOfChar($key[$i]);
        if ($number_of_text > count(listAlphabetic())) {
            $number_of_text -= count(listAlphabetic());
        }
        $result .= charOfIndex($number_of_text % count(listAlphabetic()));
    }

    return $result;
}

function decryptOneTimePad($text)
{
    // Decrypt the text using the One-Time Pad cipher
    $result = "";
    $key = readKey("file.txt", $text);

    for ($i = 0; $i < strlen($text); $i++) {
        $number_of_text = indexOfChar($text[$i]) - indexOfChar($key[$i]);
        if ($number_of_text < 0) {
            $number_of_text += count(listAlphabetic());
        }

        $result .= charOfIndex($number_of_text % count(listAlphabetic()));
    }

    return $result;
}

// Encrypt the text using the Caesar cipher
$text = "CHHOUNSOPHANON";
$key = 93622690 % 26;
echo " Caesar Cipher \n";
$encrypt = encryptCaesar($text, $key);
echo "Encrypt: " . $encrypt . "\n";
echo "Decrypt: " . decryptCaesar($encrypt, $key) . "\n";
// Encrypt the text using the Polyalphabetic cipher
$key = "CHHOUN";
if (strlen($key) < strlen($text)) {
    $finalKey = strlen($key);
    $i = 0;
    while (strlen($key) < strlen($text)) {
        $key .= $key[$i];
        $i++;
        if ($i >= $finalKey) {
            $i = 0;
        }
    }
} elseif (strlen($key) > strlen($text)) {
    $key = substr($key, 0, strlen($text));
}
echo "Polyalphabetic Cipher \n";
$encrypt = encryptPolyalphabetic($text, $key);
echo "Encrypt: " . $encrypt . "\n";
echo "Decrypt: " . decryptPolyalphabetic($encrypt, $key) . "\n";
// Encrypt the text using the One-Time Pad cipher
$key = generateString(pow(2, 2));
$file = 'file.txt';
$myfile = fopen("file.txt", "w") or die("Unable to open file!");
fwrite($myfile, "");
fwrite($myfile, $key);
echo "One Time Pad Cipher \n";
$encrypt = encryptOneTimePad($text);
echo "Encrypt: " . $encrypt . "\n";
echo "Decrypt: " . decryptOneTimePad($encrypt) . "\n";
