<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/28/16
 * Time: 8:14 AM
 */


session_start();

include ("../public_lib/connect.php");



$filename =get_input($_GET['filename']);
$ownerid = get_input($_GET['ownerid']);



if(isset($_SESSION['uid'])&&isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    $id = $_SESSION['uid'];
    if($id === $ownerid)
    {
        $time = date("U");
        $down_fequency = 0;
        //echo ($time);
        $sql = "select * from download where filename = '$filename'and create_time < '$time'and down_frequency<3 limit 1";
        $result = mysqli_query($connect,"$sql");
        //var_dump($result);
        $row = mysqli_fetch_array($result);

        //var_dump($row);
        if($row)
        {
            //var_dump($row);
            echo "You have shared your code and file</br>";
            echo "The share code of your file<br>";
            echo "<h3>".$row['down_key']."</h3>";
            echo "The download link:</br>";
            $link = "https://".$_SERVER['HTTP_HOST']."/up_down/test_down.php?link=".$row['down_link'];
            echo "<a href =".$link. ">".$link."</a>";
            exit;
        }


        // generate code
        $down_link = getUniqidName(6);
        $down_key = getUniqidName(4);
        //var_dump($down_key);
        $time = date("U");
        $sql = "insert into download (create_time, down_link,filename, down_key,ownerid,down_frequency) VALUES 
($time,'$down_link','$filename','$down_key','$ownerid',0)";
        if(!mysqli_query($connect,$sql))
        {
            echo ("Insert Data error</br>");
            echo (mysqli_error($connect));
            echo " <a href = 'javascript:history.back(-1);'> return</a> ";
            mysqli_close($connect);
            exit;
        }
        echo "The share code of your file<br>";
        echo "<h3>".$down_key."</h3>";
        echo "The download link:</br>";
        $link = "https://".$_SERVER['HTTP_HOST']."/up_down/test_down.php?link=".$down_link;
        echo "<a href =".$link. ">".$link."</a>";
        exit;


    }

}
else
{
    echo "Only logined user could share code and link!";
    echo " <a href = 'javascript:history.back(-1);'> return</a> ";
}



function getUniqidName($length=10){
    return substr(md5(uniqid(microtime(true),true)),0,$length);
}

function get_input($input)
{
    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);
    return $input;

}

