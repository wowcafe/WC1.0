<?php
class restaurantlist
{
    var $webserviceRequestData  = null;
    var $dbConnectionStatus     = null;
    var $restaurentList			= array();
    var $WSresponse             = array();
    var $authorization          = null;
    
    function __construct($requestFromWebservice)
    {
        
        $this->webserviceRequestData        = json_decode($requestFromWebservice);
        $this->authorization                = $this->webserviceRequestData->authorizstionToken;
        
        $this->authorize();
        
       	$this->dbConnectionStatus           = $this->dbConnection();
       	$this->WSresponse['status']         = 'success';
        $this->WSresponse['body']           = $this->listOfRestaurant();
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
    private function listOfRestaurant()
    {
        
            $queryString = "SELECT * FROM  `Restaurantlist`";
            $queryToRestaurantListCheck = mysqli_query($this->dbConnectionStatus,$queryString);
            if(mysqli_num_rows($queryToRestaurantListCheck)==0)
            {
                $webserviceCallResponse = $this->webserviceCallResponse('406','error','Empty List');
                print_r($webserviceCallResponse);
                die();
                
            }
            while($RestaurentResultSet = mysqli_fetch_assoc($queryToRestaurantListCheck)){
            	
            	$restaurentList[] = $RestaurentResultSet;
            }
            return $restaurentList;
            
        
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
$objRegister = new restaurantlist(file_get_contents("php://input"));

?>