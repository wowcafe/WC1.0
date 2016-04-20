<?php
$receivedUrl            = $_SERVER['REQUEST_URI'];
$receivedUrlModify_1    = rtrim($receivedUrl,"/");
$receivedUrlModify_2    = explode("/",$receivedUrlModify_1);
$callingObject          = $receivedUrlModify_2[count($receivedUrlModify_2)-1];
$callingClass           = $receivedUrlModify_2[count($receivedUrlModify_2)-2];

$classFile              = 'class/'.$callingClass.'Class.php';

$authorisation          = array();


if(!file_exists($classFile))
{
    $authorisation['status']    = 'ERROR';
    $authorisation['message']   = 'Class not found';
    $response                   = json_encode($authorisation);
    http_response_code(500);
    print_r($response);
    exit;
}
else
{
    $dbHost                 = 'localhost';
    $dbUserName             = 'ap_user';
    $dbPassword             = 'xPYG7Zi0';
    $dbSelect               = 'ap_webservicetest';
    include $classFile;
}
?>