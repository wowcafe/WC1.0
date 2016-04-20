<?php
class login
{
    var $pincodeToCheck                 = null;
    var $pincodeResourceId              = null;
    var $webserviceRequestData          = null;
    var $isEmailOrUserName              = 'E';
    var $dbConnectionStatus             = null;
    var $WSresponse                     = array();
    
    function __construct($requestFromWebservice)
    {
        $this->webserviceRequestData        = json_decode($requestFromWebservice);
        $this->pincodeToCheck               = $this->webserviceRequestData->pincode;
        $this->dbConnectionStatus           = $this->dbConnection();
        
        
        
        $this->WSresponse['status']         = 'success';
        $this->WSresponse['body']           = $this->postcodecheck();
        print_r(json_encode($this->WSresponse)); 
        
    }
    private function dbConnection()
    {
        global $dbHost;
        global $dbUserName;
        global $dbPassword;
        global $dbSelect;
        
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
    
    
    private function webserviceCallResponse($responseCode,$responseStatus,$responseMessage)
    {
        $authorisation              = array();
        $authorisation['status']    = $responseStatus;
        $authorisation['message']   = $responseMessage;
        $response                   = json_encode($authorisation);
        http_response_code($responseCode);
        return $response;
        
    }
    private function postcodecheck() 
    {
        $queryString = "SELECT * 
            FROM    `deliveryPostcode` 
            WHERE   `deliveryPostcode` = '".$this->pincodeToCheck."'";
        
        $queryToGetPostCodeDetails = mysqli_query($this->dbConnectionStatus,$queryString);
        if(mysqli_num_rows($queryToGetPostCodeDetails) == 1)
        {
            return '1';
        }
        else
        {
            $webserviceCallResponse = $this->webserviceCallResponse('410','error','Order cannot deliver on this postal code');
            print_r($webserviceCallResponse);
            die();
        }
    }    
}	
$objLogin = new login(file_get_contents("php://input"));


?>