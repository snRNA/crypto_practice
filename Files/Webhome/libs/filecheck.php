<?php
/**
 * Created by PhpStorm.
 * User: cuc
 * Date: 15-7-20
 * Time: 下午5:11
 */


function checkFiletype($file_type)
{
    $legal_file_types = Array(
        "image/gif",
        "image/jpeg",
        "image/pjpeg",
        "image/png",
        "image/bmp",
        "text/plain",
        "application/pdf",
        "application/octet-stream",
        "application/zip",
        "application/rar",
        "audio/mpeg",
        "audio/x-midi",
        "audio/x-wav",
        "application/msword",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "application/vnd.ms-powerpoint",
        "application/vnd.openxmlformats-officedocument.presentationml.presentation",
        "application/vnd.ms-excel",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    );

    foreach ($legal_file_types as $value) {
        if ($file_type == $value) {
            return true;
        }
    }
    return false;
}

