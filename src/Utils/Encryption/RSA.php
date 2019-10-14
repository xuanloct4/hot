<?php

namespace Src\Utils\Encryption;

use Src\System\Configuration;

class RSA
{
    public static function encrypt($data)
    {
        $encrypted = "";

        if (openssl_public_encrypt($data, $encrypted, Configuration::getInstance()->getPubkeyRSA()))
            $data = base64_encode($encrypted);
        else
            throw new \Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');
        return $data;
    }

    public static function decrypt($data)
    {
        $decrypted = "";
        if (openssl_private_decrypt(base64_decode($data), $decrypted, Configuration::getInstance()->getPrivkeyRSA()))
            $data = $decrypted;
        else
            $data = '';
        return $data;
    }

    public static function generateRSAKeyPair($keySize = 4096)
    {
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => (int)$keySize,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

// Create the private and public key
        $res = openssl_pkey_new($config);

// Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);

// Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];
        var_dump($privKey);
        var_dump($pubKey);
        return array("private_key" => $privKey,
            "public_key" => $pubKey);

//        $data = 'plaintext data goes here';
//// Encrypt the data to $encrypted using the public key
//        openssl_public_encrypt($data, $encrypted, $pubKey);
//// Decrypt the data using the private key and store the results in $decrypted
//        openssl_private_decrypt($encrypted, $decrypted, $privKey);
//        var_dump($decrypted);


    }
}
