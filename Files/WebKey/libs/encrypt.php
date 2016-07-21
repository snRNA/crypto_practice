<?php
/**
 * @description
 * @author huangwei
 */

function dataencrypt($rawdata){
    $key    = file_get_contents('/home/cuc/WebKey/FileKey');
    //print($key);
    $input  = isset($rawdata) ? $rawdata : "";
    if(!function_exists("hex2bin")) { // PHP 5.4起引入的hex2bin
        function hex2bin($data) {
            return pack("H*", $data);
        }
    }
    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_RANDOM);
    mcrypt_generic_init($td, $key, $iv);
    $encrypted_data1 = mcrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $array = [
        "iv" => bin2hex($iv),
        "data" => bin2hex($encrypted_data1),
    ];
    return $array;
//    print_r(bin2hex($iv)."\n");
//    print_r(bin2hex($encrypted_data1)."\n");
}
