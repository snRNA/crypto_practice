<?php
echo '<html>';
/*
$config = array(
    "digest_alg" => "sha256",
    "private_key_bits" => 1024,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

// Create the private and public key
$res = openssl_pkey_new($config);

// Extract the private key from $res to $privKey
openssl_pkey_export($res, $privKey);

var_dump($privKey);
echo '<br/>';

// Extract the public key from $res to $pubKey
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];

var_dump($pubKey);
echo '<br/>';*/

$data = '6989108b8ab35d32dbc84fecf2b589a4';

$pubKey="-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDjc2qmbLtsO/0O1pn7MA5K5nVm
aDJWQZfsvoL+59Xd1bBnMuhFX1FS6bZm8GdaZEgECIXhSg90tSSjCcq36MNv4gLz
fqPuf0jjsQe2RDsXvWG0Fta3lo8pHIJEWQjiu63CCgJAFUjSMwotqip2yGbH5Up7
1BLFaZIM1vgi4hQYTwIDAQAB
-----END PUBLIC KEY-----";

$privKey="-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAONzaqZsu2w7/Q7W
mfswDkrmdWZoMlZBl+y+gv7n1d3VsGcy6EVfUVLptmbwZ1pkSAQIheFKD3S1JKMJ
yrfow2/iAvN+o+5/SOOxB7ZEOxe9YbQW1reWjykcgkRZCOK7rcIKAkAVSNIzCi2q
KnbIZsflSnvUEsVpkgzW+CLiFBhPAgMBAAECgYBl5V7yD+QnKPjFnP5+uZitlXEi
36stWVVmijLFX7dAGmtc0EGeUoVsT6eXlju3ExXwOKFBvJwP/Nbc85YNrglfTdsd
wfYRUZt1j82h7DnEDNsvhgcCPH0sZi+0qM3u7XnLwQCI4v10QGIujr5XlU9vGYSR
+gCpTpl5/u6KJgI+gQJBAPnQ+qQm1geYjLFtnLEcEMARJXPfcpzAA0P+Ck91xxdp
2zZeRF44f+XDeh0gO3Fd1AIzZ8T+P6ShNvoIXnfBNW0CQQDpFLacpw8xZ3QOx9gP
CxM1Z3fizecOLsYc6P9eg2pddTUjDcjnI6Zx6T09IMb1CcBUero6KmWMjfzaNiPw
kDsrAkEA8kykXcShQRrQE2N6YDoVcQTwa5PlqW1/fVoQDAPzR51PlksWSsDIJEVV
0pwpq4pTEJNlaackeXw4Q4kMf2CxfQJBAImh1I8+Ssdmim6r7VY8uPQBDBbedQC3
9/5cS2dY/HcBXgY7/pUWRRPgoWu2LiXFw09fRRZRsLNFqLiF3cUQtg8CQQDJIsRD
poSU6Wl+hdTaOkmZ6NoMO/+7lYZjQe+1hb7uH6I4efdY2NwQCewHRONLUkG2rsgf
8D1kRpNPjyasbr+T
-----END PRIVATE KEY-----";

/*
// Encrypt the data to $encrypted using the public key
openssl_public_encrypt($data, $encrypted, $pubKey);

var_dump($encrypted);
echo '<br/>';

// Decrypt the data using the private key and store the results in $decrypted
openssl_private_decrypt($encrypted, $decrypted, $privKey);

echo $decrypted.'<br/>';
*/
//create signature
openssl_sign($data, $signature, $privKey, OPENSSL_ALGO_SHA256);
var_dump($signature);
echo '<br/>';
$signature=base64_encode($signature);
echo "base64后：";
var_dump($signature);
echo '<br/>';
$signature=base64_decode($signature);
echo "还原后：";
var_dump($signature);
echo '<br/>';
//verify signature
$r = openssl_verify($data, $signature, $pubKey, "sha256WithRSAEncryption");
var_dump($r);
echo '<br/>';

//include $_SERVER['DOCUMENT_ROOT'] . "/libs/includes.php";
//include $Connect_Lib;
/*
include "./accounts/conn.php";
$username = 'litao';
$userid='9';
$result=mysql_query("select prikey from user where username='$username' limit 1");
$row=mysql_fetch_array($result);
$priKey=$row['prikey'];
var_dump($priKey);
$outputfilepath='./index.html';
$file_hash_sha1 = sha1_file($outputfilepath);
echo $file_hash_sha1.'<br/>';
$file_hash_md5 = md5_file($outputfilepath);
echo $file_hash_md5.'<br/>';
openssl_sign($file_hash_sha1, $signaturesha1, $priKey, OPENSSL_ALGO_SHA256);
echo $signaturesha1.'<br/>';
openssl_sign($file_hash_md5, $signaturemd5, $priKey, OPENSSL_ALGO_SHA256);
echo $signaturemd5.'<br/>';
$fileName="uzi";
$fileSize='23';
$upload_iv='123456';
$sql = "INSERT INTO file(filename,size,savefilename,ownername,ownerid,uploadtime,MD5,SHA1,iv,directory,MD5S,SHA1S)
VALUES('$fileName','$fileSize','$outputfilename','$username','$userid',CURRENT_TIME(),
'$file_hash_md5','$file_hash_sha1','$upload_iv','$outputfilepath','$signaturemd5','$signaturesha1')";
var_dump(mysql_query($sql, $conn));*/

echo '</html>'; 

?>
















