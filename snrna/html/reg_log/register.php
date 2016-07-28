<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/20/16
 * Time: 12:43 PM
 */

if (!isset($_POST['sign_up']))
{
    echo "Access denied for without sign up";
    header("Location:../index.html");
    exit;
}
//
//if((!isset($_post['username']))or(!isset($_POST['password']))or(!isset($_POST['email'])))
//{
//    echo "Some input could be blank,retry.</br>";
//    echo "<a = href = 'javascript:history.back(-1);'>return</a>";
//    exit;
//}

$username = get_input($_POST['username']);
$password = get_input($_POST['password']);
$email = get_input($_POST['email']);


if(!preg_match('/^[\x{4E00}-\x{9FFF}\w\-\_\.]+$/u',$username))
{
    echo("Error! Username is out of the rule!</br>");
    echo "<a href='javascript:history.back(-1);'>return</a>";
    exit;

}


if(strlen($password)<8 ||strlen($password)>36)
{
    echo "Error! The length of the password is not between 8 and 36 </br>";
    echo "<a href='javascript:history.back(-1)'>return</a>";
    exit;
}else
{
    if(!check_pass($password))
    {
        echo "Error! The password is too easy,please make it harder! </br>";
        echo "<a href='javascript:history.back(-1)'>return</a>";
        exit;
    }
}


$password = password_hash($password,PASSWORD_DEFAULT);

//$config = array(
//    "digest_alg" => "sha256",
//    "private_key_bits" => 1024,
//    "private_key_type" => OPENSSL_KEYTYPE_RSA,
//);
//
//
//$res = openssl_pkey_new($config);
//openssl_pkey_export($res,$pri_key);
//$pub_key = openssl_pkey_get_details($res);
//$pub_key = $pub_key['key'];

include('../public_lib/connect.php');

$check = mysqli_query($connect,"SELECT uid FROM user WHERE username ='$username' limit 1");
if(mysqli_fetch_array($check)){
    echo "Ops! username' ".$username. " 'has benn existed.<a href = 'javascript:history.back(-1);'> return</a> ";
    mysqli_close($connect);
    exit;
}
echo(mysqli_error($connect));

$uniq_id = getUniqidName();
$sql = "INSERT INTO user (username, password, email, create_time,pub_key,pri_key,uniq_id)VALUES ('$username', '$password','$email',NOW(),'$pub_key','$pri_key','$uniq_id')";
if(mysqli_query($connect,$sql)){
    mysqli_close($connect);
    exit ("Sign up Success! Go to <a href = '../login.html'>Sign in</a>");

}else{
    echo "Add user failed!","</br>";
    echo (mysqli_error($connect));
    mysqli_close($connect);
    echo " <a href = 'javascript:history.back(-1);'> return</a> ";
    exit;
}



function get_input($input)
{
    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);
    return $input;

}

function check_pass($pass)
{
    return (preg_match('/[0-9]/', $pass) && preg_match('/[a-z]/i', $pass) && preg_match('/[\-\_\.\+\=]/', $pass));
}

function getUniqidName($length=10){
    return substr(md5(uniqid(microtime(true),true)),0,$length);
}
