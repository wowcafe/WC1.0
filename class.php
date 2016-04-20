<?php
class configuration
{
    public function dbConnection()
    {
        $dbHost                 = 'localhost';
        $dbUserName             = 'ap_user';
        $dbPassword             = 'xPYG7Zi0';
        $dbSelect               = 'ap_webservicetest';
        
        $conn = new mysqli($dbHost, $dbUserName, $dbPassword);
        if ($conn->connect_error) {
            $webserviceCallResponse = $this->webserviceCallResponse('401','error','Database connection failed');
            print_r($webserviceCallResponse);
            die();
        }
        else
        {
            $dbconn = mysqli_select_db($conn,$dbSelect);
            if(!$dbconn)
            {
                $webserviceCallResponse = $this->webserviceCallResponse('402','error','Database not found');
                print_r($webserviceCallResponse);
                die();
            }
        }
        return $conn;
    }
}
?>