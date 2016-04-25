<?php
    session_start();
    $dbHost                 = 'localhost';
    $dbUserName             = 'ap_user';
    $dbPassword             = 'xPYG7Zi0';
    $dbSelect               = 'ap_webservicetest';
    $dbPrefix               = 'ap_';
    $conn                   = new mysqli($dbHost, $dbUserName, $dbPassword);
    if ($conn->connect_error) 
    {
        echo "Database connection error";
        die();
    }
    else
    {
        $dbconn = mysqli_select_db($conn,$dbSelect);
        if(!$dbconn)
        {
            echo "Database not found";
            die();
        }
    }
?>