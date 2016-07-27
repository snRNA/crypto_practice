<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/26/16
 * Time: 10:02 AM
 */

function dataencrypt($rawdata,$key){
    //$key = file_get_contents('../Key/filekey');
//print($key);
    $input = isset($rawdata) ? $rawdata : "";
    if(!function_exists("hex2bin")) { // PHP 5.4起引入的hex2bin
        function hex2bin($data) {
            return pack("H*", $data);
        }
    }
    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_RANDOM);
    mcrypt_generic_init($td, $key, $iv);
    $block = mcrypt_enc_get_block_size($td);
    $encrypted_data1 = mcrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $array = [
        "iv" => bin2hex($iv),
        "data" => bin2hex($encrypted_data1),
        "block" =>$block
    ];
    return $array;
// print_r(bin2hex($iv)."\n");
// print_r(bin2hex($encrypted_data1)."\n");
}


/**
 * This library is unsafe because it does not MAC after encrypting
 */
class UnsafeOpensslAES
{
    const METHOD = 'aes-256-cbc';

    public static function encrypt($message, $key)
    {
        if (mb_strlen($key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        $ivsize = openssl_cipher_iv_length(self::METHOD);
        $iv = openssl_random_pseudo_bytes($ivsize);

        $ciphertext = openssl_encrypt(
            $message,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        return $iv . $ciphertext;
    }

    public static function decrypt($message, $key)
    {
        if (mb_strlen($key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        $ivsize = openssl_cipher_iv_length(self::METHOD);
        $iv = mb_substr($message, 0, $ivsize, '8bit');
        $ciphertext = mb_substr($message, $ivsize, null, '8bit');

        return openssl_decrypt(
            $ciphertext,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
    }
}