<?php 
class forgetpassword
{
    var $registeredEmailOrUsername      = null;
    var $webserviceRequestData          = null;
    var $isEmailOrUserName              = 'E';
    var $dbConnectionStatus             = null;
    var $WSresponse                     = array();
    function __construct($requestFromWebservice)
    {
        $this->webserviceRequestData        = json_decode($requestFromWebservice);
        $this->registeredEmailOrUsername   = $this->webserviceRequestData->userEmail;
        $this->dbConnectionStatus           = $this->dbConnection();
        
        $emailvalidation                    = $this->emailValidationCheck();
        $this->WSresponse['status']         = 'success';
        $this->WSresponse['body']           = $this->requestForNewPassword();
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
    private function emailValidationCheck()
    {
        if ($this->registeredEmailOrUsername == "" || $this->registeredEmailOrUsername == null)
        {
            $webserviceCallResponse = $this->webserviceCallResponse('405','error','Email cannot be empty');
            print_r($webserviceCallResponse);
            die();
        }
        else if (filter_var($this->registeredEmailOrUsername, FILTER_VALIDATE_EMAIL) === false)        
            $this->isEmailOrUserName = 'U';
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
    private function requestForNewPassword() 
    {
        if($this->isEmailOrUserName == 'U')
        {
            $queryString = "SELECT * 
            FROM    `Customer` 
            WHERE   `CustomerUserName` = '".$this->registeredEmailOrUsername."'";
        } else if($this->isEmailOrUserName == 'E')
        {
            $queryString = "SELECT * 
            FROM    `Customer` 
            WHERE   `CustomerEmail`    = '".$this->registeredEmailOrUsername."'";
        }
        $queryToGetLoginDetails = mysqli_query($this->dbConnectionStatus,$queryString);
        if(mysqli_num_rows($queryToGetLoginDetails) == 1)
        {
            return mysqli_fetch_assoc($queryToGetLoginDetails);
        }
        else
        {
            $webserviceCallResponse = $this->webserviceCallResponse('407','error','User not found');
            print_r($webserviceCallResponse);
            die();
        }
    }  
}
$objForgetpassword = new forgetpassword(file_get_contents("php://input"));