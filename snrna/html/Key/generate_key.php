<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/26/16
 * Time: 9:52 AM
 */



$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 1024,
    "private_key_type" => OPENSSL_KEYTYPE_RSA
);


$res = openssl_pkey_new($config);
openssl_pkey_export($res, $pri_key);
$pubkey = openssl_pkey_get_details($res);
$pubkey = $pubkey['key'];

$file = fopen("public.key","w");
fclose($file);

file_put_contents("public.key",$pubkey);

$file = fopen("private.key","w");
fclose($file);

file_put_contents("private.key",$pri_key);


echo($pubkey);
echo "</br>";
echo($pri_key);
