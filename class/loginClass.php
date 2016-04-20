<?php
class login
{
    var $loginVariableEmailOrUserName   = null;
    var $loginVariablePassword          = null;
    var $webserviceRequestData          = null;
    var $isEmailOrUserName              = 'E';
    var $dbConnectionStatus             = null;
    var $WSresponse                     = array();
    
    function __construct($requestFromWebservice)
    {
        $this->webserviceRequestData        = json_decode($requestFromWebservice);
        $this->loginVariableEmailOrUserName = $this->webserviceRequestData->userEmail;
        $this->loginVariablePassword        = $this->webserviceRequestData->password;
        $this->dbConnectionStatus           = $this->dbConnection();
        
        $emailvalidation                    = $this->emailValidationCheck();
        $passwordValidation                 = $this->passwordValidationCheck();
        
        $this->WSresponse['status']         = 'success';
        $this->WSresponse['body']           = $this->userLogin();
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
        if ($this->loginVariableEmailOrUserName == "" || $this->loginVariableEmailOrUserName == null)
        {
            $webserviceCallResponse = $this->webserviceCallResponse('405','error','Email cannot be empty');
            print_r($webserviceCallResponse);
            die();
        }
        else if (filter_var($this->loginVariableEmailOrUserName, FILTER_VALIDATE_EMAIL) === false)        
            $this->isEmailOrUserName = 'U';
    }
    private function passwordValidationCheck()
    {
        if($this->loginVariablePassword == "" || $this->loginVariablePassword == null)
        {
            $webserviceCallResponse = $this->webserviceCallResponse('405','error','Password cannot be empty');
            print_r($webserviceCallResponse);
            die();
        }
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
    
    private function userLogin() 
    {
        if($this->isEmailOrUserName == 'U')
        {
            $queryString = "SELECT * 
            FROM    `Customer` 
            WHERE   `CustomerUserName` = '".$this->loginVariableEmailOrUserName."'
            AND     `CustomerPassword` = '".$this->loginVariablePassword."'";
        } else if($this->isEmailOrUserName == 'E')
        {
            $queryString = "SELECT * 
            FROM    `Customer` 
            WHERE   `CustomerEmail`    = '".$this->loginVariableEmailOrUserName."'
            AND     `CustomerPassword` = '".$this->loginVariablePassword."'";
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
$objLogin = new login(file_get_contents("php://input"));


?>