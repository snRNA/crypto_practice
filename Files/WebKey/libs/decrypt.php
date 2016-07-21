<?php
/**
 * @description
 * @author huangwei
 * @author#2 xxxxxxx
 */

function datadecrypt($iv, $data)
{
    $key = file_get_contents('/home/cuc/WebKey/FileKey');
    $iv_hex = isset($iv) ? $iv : "";
    $input_hex = isset($data) ? $data : "";
    if (!function_exists("hex2bin")) { // PHP 5.4起引入的hex2bin
        function hex2bin($data)
        {
            return pack("H*", $data);
        }
    }
    $iv = hex2bin($iv_hex);
    $input = hex2bin($input_hex);
    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
    mcrypt_generic_init($td, $key, $iv);
    $decrypted_data = mdecrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return $decrypted_data;
//    print_r($decrypted_data . "\n");
}
