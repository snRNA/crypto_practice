<?php
$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 32,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);
    
// Create the private and public key
$res = openssl_pkey_new($config);
openssl_pkey_export($res, $privKey);
print($privKey);
