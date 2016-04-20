<?php
class register
{
    var $webserviceRequestData  = null;
    var $customerUserName       = null;
    var $customerPassword       = null;
    var $customerEmail          = null;
    var $customerLoginType      = null;
    var $customerFacebookId     = null;
    var $customerName           = null;
    var $customerImage          = null;
    var $customerLoginTime      = null;
    var $dbConnectionStatus     = null;
    var $WSresponse             = array();
    function __construct($requestFromWebservice)
    {
        
        $this->webserviceRequestData        = json_decode($requestFromWebservice);
        $this->customerUserName             = (isset($this->webserviceRequestData->username))  ? $this->webserviceRequestData->username    : null;
        $this->customerPassword             = (isset($this->webserviceRequestData->password))  ? $this->webserviceRequestData->password    : null;
        $this->customerEmail                = (isset($this->webserviceRequestData->email))     ? $this->webserviceRequestData->email       : null; 
        $this->customerLoginType            = (isset($this->webserviceRequestData->logintype)) ? $this->webserviceRequestData->logintype   : null;
        $this->customerFacebookId           = (isset($this->webserviceRequestData->facebookid))? $this->webserviceRequestData->facebookid  : null;
        $this->customerName                 = (isset($this->webserviceRequestData->name))      ? $this->webserviceRequestData->name        : null;
        $this->customerImage                = (isset($this->webserviceRequestData->image))     ? $this->webserviceRequestData->image       : null;
        $this->customerLoginTime            = (isset($this->webserviceRequestData->logintime)) ? $this->webserviceRequestData->logintime   : null;
        $this->dbConnectionStatus           = $this->dbConnection();
        
        $emailvalidation                    = $this->emailValidationCheck();
        $passwordValidation                 = $this->passwordValidationCheck();
        $loginTypeValidation                = $this->loginTypeValidationCheck();
        //$receivedrequestInArray['uId']  = $this->customerRegister();
        $this->WSresponse['status']         = 'success';
        $this->WSresponse['body']           = json_decode($requestFromWebservice, true);
        $this->WSresponse['body']['loginID']= $this->customerRegister();
        print_r($this->WSresponse);
        
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
        if ($this->customerEmail == "" || $this->customerEmail == null)
        {
            $webserviceCallResponse = $this->webserviceCallResponse('405','error','Email cannot be empty');
            print_r($webserviceCallResponse);
            die();
        }
        else if (filter_var($this->customerEmail, FILTER_VALIDATE_EMAIL) === false)
        {
            $webserviceCallResponse = $this->webserviceCallResponse('405','error','Invalid email address');
            print_r($webserviceCallResponse);
            die();
        }
        else if (1)
        {
            $queryString = "SELECT * FROM  `Customer` WHERE  `CustomerEmail` = '".$this->customerEmail."'";
            $queryToEmailExistenceCheck = mysqli_query($this->dbConnectionStatus,$queryString);
            if(mysqli_num_rows($queryToEmailExistenceCheck)>0)
            {
                $webserviceCallResponse = $this->webserviceCallResponse('406','error','Customer allready exists');
                print_r($webserviceCallResponse);
                die();
                
            }
            
        }
    }
    
    private function passwordValidationCheck()
    {
        if($this->customerPassword == "" || $this->customerPassword == null)
        {
            $webserviceCallResponse = $this->webserviceCallResponse('405','error','Password cannot be empty');
            print_r($webserviceCallResponse);
            die();
        }
    }
    private function loginTypeValidationCheck()
    {
        if($this->customerLoginType == "" || $this->customerLoginType == null)
        {
            $webserviceCallResponse = $this->webserviceCallResponse('405','error','Login type cannot be empty');
            print_r($webserviceCallResponse);
            die();
        }
        else if ($this->customerLoginType != 'FB' && $this->customerLoginType != 'Email')
        {
            $webserviceCallResponse = $this->webserviceCallResponse('405','error','Login type must be Email or FB');
            print_r($webserviceCallResponse);
            die();
        }
    }
    private function webserviceCallResponse($responseCode,$responseStatus,$responseMessage)
    {
        $authorisation          = array();
        $authorisation['status']    = $responseStatus;
        $authorisation['message']   = $responseMessage;
        $response                   = json_encode($authorisation);
        http_response_code($responseCode);
        return $response;
        
    }
    private function customerRegister()
    {
        $queryString =  "INSERT INTO `Customer` SET
                        `CustomerUserName`      = '".$this->customerUserName."',
                        `CustomerPassword`      = '".$this->customerPassword."',
                        `CustomerEmail`         = '".$this->customerEmail."',
                        `CustomerLoginType`     = '".$this->customerLoginType."',
                        `CustomerFacebookId`    = '".$this->customerFacebookId."',
                        `CustomerName`          = '".$this->customerName."',
                        `CustomerImage`         = '".$this->customerImage."',
                        `CustomerLoginTime`     = '".$this->customerLoginTime."'";
        $queryToRegisteruser = mysqli_query($this->dbConnectionStatus,$queryString);
        if(!$queryToRegisteruser)
        {
            $webserviceCallResponse = $this->webserviceCallResponse('403','error','Customer registration failed');
            print_r($webserviceCallResponse);
            die();
            
        }
        return mysqli_insert_id($this->dbConnectionStatus);
    }
}
$objRegister = new register(file_get_contents("php://input"));

?>