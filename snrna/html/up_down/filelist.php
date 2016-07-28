<html>
<head>
    <meta charset='UTF-8'>
    <title>
        我的文件
    </title>
</head>
<center>
    <div>
        <?php
        session_start();
        include ("../public_lib/check_login.php");
        //include $_SERVER['DOCUMENT_ROOT'] . "/libs/includes.php";
        include ("../public_lib/connect.php");
        $uid =$_SESSION['uid'];
        $username = $_SESSION['username'];
        $result = mysqli_query($connect,"SELECT * FROM file where ownerid ='$uid'");
        echo "
        <div id='main-table-div'>
            <table border='1' style='table-layout: fixed;  text-overflow:ellipsis;text-align: center;'>
            <thead style='overflow-y: auto;display: block;'>
                <tr id='#main-table-th-tb'>
                    <th class='col1'>编号</th>
                    <th class='col2'>文件名（点击分享原文件）</th>
                    <th class='col6'>SHA-1</th>
                    <th class='col7'>上传时间</th>
                </tr>
            </thead>
         ";
        echo "<tbody style='height: 300px;overflow-y: auto;display: block'>";
        while ($row = mysqli_fetch_array($result)) {
            $origin_name = $row['origin_name'];
            $filename = $row['filename'];
            $upload_time = $row['uploadtime'];
            $SHA1 = $row['file_sha1'];
            echo "<tr>";
            echo "<tr id ='#main-table-th-tb'>";
            echo "<td class='col1'>" . $row['fid'] . "</td>";
            echo "<td class='col2'style ='...'>
            <a href=share.php?filename=$filename&ownerid=$uid>$origin_name</a>";
            echo "<td class='col6'>".$SHA1."</td>";
            echo "<td class='col7'>".$upload_time."</td>";
            echo "</tr>";}


        echo " </tbody > ";
        echo "</table >
        </div > ";
        mysqli_close($connect);
        ?>
    </div>
    <div id='suggestions'>
        <a href='../reg_log/user_center.php'>用户中心</a>
        <a href='upload.php'>上传文件</a>
        <a href='../reg_log/logout.php'>退出</a>
    </div>
</center>
</html>