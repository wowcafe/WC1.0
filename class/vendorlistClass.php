<?php
class vendorlist
{
    var $webserviceRequestData  = null;
    var $dbConnectionStatus     = null;
    var $vendorList			= array();
    var $WSresponse             = array();
    var $authorization          = null;
    
    function __construct($requestFromWebservice)
    {
        
        $this->webserviceRequestData        = json_decode($requestFromWebservice);
        $this->authorization                = $this->webserviceRequestData->authorizstionToken;
        
        $this->authorize();
        
       	$this->dbConnectionStatus           = $this->dbConnection();
       	$this->WSresponse['status']         = 'success';
        $this->WSresponse['body']           = $this->listOfVendor();
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
    private function authorize()
    {
        if ($this->authorization != '7a62f1e4f1228103e55bdacd12dac8a8') {
            $webserviceCallResponse = $this->webserviceCallResponse('406','error','Not authorized');
            print_r($webserviceCallResponse);
            die();
        }
    }
    private function listOfVendor()
    {
        
            $queryString = "SELECT * FROM  `Vendorlist`";
            $queryToVendorListCheck = mysqli_query($this->dbConnectionStatus,$queryString);
            if(mysqli_num_rows($queryToVendorListCheck)==0)
            {
                $webserviceCallResponse = $this->webserviceCallResponse('406','error','Empty List');
                print_r($webserviceCallResponse);
                die();
                
            }
            while($VendorResultSet = mysqli_fetch_assoc($queryToVendorListCheck)){
            	
            	$vendorList[] = $VendorResultSet;
            }
            return $vendorList;
            
        
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
$objRegister = new vendorlist(file_get_contents("php://input"));

?>