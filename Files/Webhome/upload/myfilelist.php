<html>
<head>
    <meta charset='UTF-8'>
    <title>
        我的文件
    </title>
    <link rel="stylesheet" type="text/css" href="/FileTables.css">
</head>
<center>
    <div>
        <?php
        session_start();

        include $_SERVER['DOCUMENT_ROOT'] . "/libs/includes.php";
        include $Connect_Lib;

        function GetFile_Encrypted($SavedFileName)
        {
            return file_get_contents($upload_folder . $SavedFileName);
        }

        $result = mysql_query("SELECT * FROM file");


        echo "
        <div id='main-table-div'>
            <table border='1' style='table-layout: fixed;  text-overflow:ellipsis;text-align: center;'>
            <thead style='overflow-y: auto;display: block;'>
                <tr id='#main-table-th-tb'>
                    <th class='col1'>编号</th>
                    <th class='col2'>文件名（点击下载原文件）</th>
                    <th class='col3'>文件大小</th>
                    <th class='col5'>MD5</th>
                    <th class='col6'>SHA-1</th>
                    <th class='col7'>上传时间</th>
                    <th class='col8'>文件校验</th>
                    <th class='col9'>删除</th>
                </tr>
            </thead>
         ";
        $user_name = $_SESSION['username'];
        $user_id = $_SESSION['userid'];

        echo "<tbody style='height: 300px;overflow-y: auto;display: block'>";
        while ($row = mysql_fetch_array($result)) {
            $savefilename = $row['savefilename'];
            $filename = $row['filename'];
            $filenameencode = urlencode($filename);
            $MD5 = $row['MD5'];
            $SHA1 = $row['SHA1'];
            if (($row['ownername'] == $user_name) && ($row['ownerid'] == $user_id)) {
                echo "<tr>";
                echo "<tr id='#main-table-th-tb'>";
                echo "<td class='col1'>" . $row['fid'] . "</td>";
                echo "<td class='col2' style='overflow: hidden;text-overflow: ellipsis;white-space: nowrap;'>
                <a href=myfileaction.php?action=save&file=$savefilename&saveas=$filenameencode>$filename</a>
              </td>";
                echo "<td class='col3'>" . round($row['size'] / 1024) . "KB</td>";
                echo "<td class='col5'>
                        <a href='/echo.php?echo=$MD5'  target='_blank' title='$MD5' >显示</a>
                        <a href='/echo.php?echo=$MD5&download=1&save_as={$filename}_md5.txt'  target='_blank' title='$MD5' >下载</a>
                      </td>";
                echo "<td class='col6'>
                        <a href='/echo.php?echo=$SHA1' target='_blank' title='$SHA1'>显示</a>
                        <a href='/echo.php?echo=$SHA1&download=1&save_as={$filename}_sha1.txt' target='_blank' title='$SHA1'>下载</a>
                      </td>";
                echo "<td class='col7'>" . $row['uploadtime'] . "</td>";
                echo "<td class='col8'><a href=put_check_file.php?fid=$fileID>校验</a></td>";
                echo "<td class='col9'><a href='myfileaction.php?action=del&file=$savefilename target='_blank'  >删除</td></td>";
                echo "</tr>";
            }
        }

        echo " </tbody > ";

        echo "</table >
        </div > ";

        mysql_close($conn);
        ?>
    </div>
    <div id='suggestions'>
        <a href='../accounts/my.php'>用户中心</a>
        <a href='upload.php'>上传文件</a>
        <a href='../accounts/login.php?action=logout'>退出</a>
    </div>
</center>
</html>