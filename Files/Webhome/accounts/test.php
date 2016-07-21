<?php
$pwd = "smanderlitao-";
$password = password_hash($pwd, PASSWORD_DEFAULT);
echo $password . '\n';
var_dump(password_verify($pwd, $password));
?>
