<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/22/16
 * Time: 8:25 AM
 */

session_start();

if(!isset($_POST['sign_in']))
{
    echo "Access denied for without sign in";
    header("Location:../index.html");
}


$username = get_input($_POST['username']);
$password = get_input($_POST['password']);


include("../public_lib/connect.php");
//var_dump($username);
$sql = "SELECT * FROM user WHERE username = '$username' limit 1";
$query = mysqli_query($connect,$sql);
//var_dump($query);

if($query){
    $data = mysqli_fetch_array($query);
    //var_dump($data);
    if(password_verify($password,$data['password']))
    {
        $_SESSION['username'] = $username;
        $_SESSION['uid'] = $data['uid'];
        //var_dump($_SESSION);
        echo "</br>Welcome ".$username." !</br>";
        echo "Go to <a href = 'user_center.php'>User Center</a>";
        mysqli_close($connect);
        exit;
    }
    else
    {
        echo "username or password wrong,please retry!</br>";
        echo "<a href='javascript:history.back(-1)'>return</a>";
        mysqli_close($connect);
        exit;
    }


}

echo "Sign in failed,please retry!</br>";
echo "<a href='javascript:history.back(-1)'>return</a>";
mysqli_close($connect);
exit;


function get_input($input)
{
    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);
    return $input;

}