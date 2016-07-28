<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/28/16
 * Time: 10:25 AM
 */

include ("../public_lib/connect.php");

session_start();

if(!isset($_GET['link']))
{
    echo "Access denied";
    echo " <a href = 'javascript:history.back(-1);'> return</a> ";
    exit;
}

$_SESSION['link'] = $_GET['link'];
$link = $_GET['link'];

if(isset($_SESSION['uid'])&&isset($_SESSION['username']))
{
    $link = $_GET['link'];
    $username = $_SESSION['username'];
    $uid = $_SESSION['uid'];

    //var_dump($link);
    $sql = "select * from download where down_link = '$link'";
    $result = mysqli_query($connect,$sql);
    $row = mysqli_fetch_array($result);


    //var_dump($row['ownerid']);
    //var_dump($uid);
    if ($uid === $row['ownerid'])
    {
        echo "Your are the uploader of the file<br>";
        echo "please download directly<br>";
        $code = $row['down_key'];
        $url = "https://".$_SERVER['HTTP_HOST']."/up_down/downloading.php?code=".$code."&link=".$link;
        echo "<a href =".$url. ">".$url."</a>";
        //echo "<meta http-equiv=\"Refresh\" content =\"5;url=downloading.php?code=".$link;
        exit;
        //

    }else{
        //$input_code ="";
        echo "please input the share code of the file<br>";
        echo "<form name=\"down\" method=\"post\" action = \"downloading.php\" autocomplete=\"off\" >
    <p>
        code <input id ='code' name=\"code\" type=\"text\" class=\"input\" >
    </p>
    <input hidden name=\"link\" type=\"text\" class=\"input\" value=".substr($link,0,6).">
    <p>
        <input type= 'submit' name=\"submit\" value=\"submit\"/>
    </p>
</form>";

        exit;

    }




} else
{
    echo "please input the share code of the file<br>";
    echo "<form name=\"down\" method=\"post\" action = \"downloading.php\">
    <p>
        code <input id ='code' name=\"code\" type=\"text\" class=\"input\"/>
    </p>
    <input hidden name=\"link\" type=\"text\" class=\"input\" value=".substr($link,0,6).">
    <p>
        <input type= 'submit' name=\"submit\" value=\"submit\"/>
    </p>
</form>";

    exit;
}


