<?php
/**
 * Created by IntelliJ IDEA.
 * User: loctv
 * Date: 10/3/19
 * Time: 1:13 AM
 */

namespace Src\Utils\Encryption;


class AES
{
    public static function safeEncrypt($message, $key)
    {
        $nonce = \Sodium\randombytes_buf(
            \Sodium\CRYPTO_SECRETBOX_NONCEBYTES
        );

        return base64_encode(
            $nonce.
            \Sodium\crypto_secretbox(
                $message,
                $nonce,
                $key
            )
        );
    }

    /**
     * Decrypt a message
     *
     * @param string $encrypted - message encrypted with safeEncrypt()
     * @param string $key - encryption key
     * @return string
     */
    public static function safeDecrypt($encrypted, $key)
    {
        $decoded = base64_decode($encrypted);
        $nonce = mb_substr($decoded, 0, \Sodium\CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        $ciphertext = mb_substr($decoded, \Sodium\CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');

        return \Sodium\crypto_secretbox_open(
            $ciphertext,
            $nonce,
            $key
        );
    }
}