<?php
/**
 * Created by PhpStorm.
 * User: KomeijiKuroko
 * Date: 2015/7/21
 * Time: 23:53
 */

if ($_GET['download'] == 1) {
    $save_as_name = $_GET['save_as'];
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$save_as_name");
}
echo $_GET['echo'];