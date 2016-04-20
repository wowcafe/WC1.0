<?php
class usernameAvailable
{
    var $webserviceRequestData  = null;
    var $customerUserName       = null;
    var $dbConnectionStatus     = null;
    var $WSresponse             = array();
    function __construct($requestFromWebservice)
    {
        
        $this->webserviceRequestData        = json_decode($requestFromWebservice);
        $this->customerUserName             = (isset($this->webserviceRequestData->username))  ? $this->webserviceRequestData->username    : null;
        $this->dbConnectionStatus           = $this->dbConnection();
        $userAvailable                   	= $this->userNameValidationCheck();
       	$this->WSresponse['status']         = 'success';
        $this->WSresponse['body']           = json_decode($requestFromWebservice, true);
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
    private function userNameValidationCheck()
    {
        if ($this->customerUserName == "" || $this->customerUserName == null)
        {
            $webserviceCallResponse = $this->webserviceCallResponse('405','error','Username cannot be empty');
            print_r($webserviceCallResponse);
            die();
        }
        else if (1)
        {
            $queryString = "SELECT * FROM  `Customer` WHERE  `CustomerUserName` = '".$this->customerUserName."'";
            $queryToEmailExistenceCheck = mysqli_query($this->dbConnectionStatus,$queryString);
            if(mysqli_num_rows($queryToEmailExistenceCheck)>0)
            {
                $webserviceCallResponse = $this->webserviceCallResponse('406','error','Customer allready exists');
                print_r($webserviceCallResponse);
                die();
                
            }
            
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
    
}
$objRegister = new usernameAvailable(file_get_contents("php://input"));

?>