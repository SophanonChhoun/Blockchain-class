// First Exercise

import CryptoJS from 'crypto-js';
import fs from 'fs';
import readline from 'readline';
import crypto from 'crypto';

let param = "Sophanon Chhoun"
let key = "1234567890123456"

const read = readline.createInterface({
    input: process.stdin,
    output: process.stdout,
});

function encrypt(param, key)
{
    let ciphertext = CryptoJS.TripleDES.encrypt(param, key);
    const encodedWord = CryptoJS.enc.Utf8.parse(ciphertext.toString());
    const encoded = CryptoJS.enc.Base64.stringify(encodedWord);
    return encoded;
}

function decrypt(param, key)
{
    const decodedWord = CryptoJS.enc.Base64.parse(param);
    const decoded = CryptoJS.enc.Utf8.stringify(decodedWord);
    let plaintext = CryptoJS.TripleDES.decrypt(decoded, key);
    return plaintext.toString(CryptoJS.enc.Utf8);
}

function checkSum() {
    const read = readline.createInterface({
        input: process.stdin,
        output: process.stdout,
    });


    read.question(`Input file path:`, name => {
        const filePath = name;
        let hash = CryptoJS.SHA256(readFile(name)).toString(CryptoJS.enc.Hex);
        console.log(`Hash: ${hash}`);
        read.question(`Input Sha256:`, algorithm => {
            console.log(`Alogrithm: ${algorithm}`);
        });
    });
}

function checksumFile(algorithm) {
    return new Promise(function (resolve, reject) {
      let hash = crypto.createHash(algorithm).setEncoding('hex');
      read.question(`Input file path:`, name => {
        fs.createReadStream(name)
            .once('error', reject)
            .pipe(hash)
            .once('finish', function () {
                resolve(hash.read());
            });
        });
        
    });
}

function readSha256()
{
    return new Promise(function (resolve, reject) {
        read.question(`Input Sha256:`, algorithm => {
            resolve(algorithm);
        });
    });
}


// bf61b62aaa66c7c7639942a94de4c9ae8280c08f17d4eac2e44644d9fc8ace6f
// /Users/chhounsophanon/Downloads/openssl-1.1.1p.tar.gz

let cipher = encrypt(param, key);
console.log("Encrypt:", cipher);

let decipher = decrypt(cipher, key);
console.log("Decrypt:", decipher);

// Second Exercise
// checkSum()

checksumFile('sha256').then(async function (hash) {
    console.log(`Hash: ${hash}`);
    let existSha = await readSha256();
    console.log(`Alogrithm: ${existSha}`);
    if (existSha === hash) {
        console.log("File is safe");
    }else {
        console.log("File is not safe");
    }
    read.close()
    read.removeAllListeners()
});

