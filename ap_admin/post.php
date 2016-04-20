<?php
session_start();
if(isset($_POST['submit']) || isset($_GET))
{
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
    
    if($_POST['submit'] == 'submitForLogin')
    {
        $sql = 'SELECT * FROM '.$dbPrefix.'admin WHERE 
               `username` = "'.$_POST['username'].'" AND
               `password` = "'.$_POST['password'].'"';
        $query = mysqli_query($conn,$sql);
        if(mysqli_num_rows($query) == 1)
        {
            $_SESSION['adminLogin'] = 1;
            $_SESSION['username']   = $_POST['username'];
            header('Location:dashboard.php');
        }
        else
        {
            $_SESSION['adminLogin'] = 2;
            header('Location:index.php');
        }
    }
    if($_POST['submit'] == 'postcodevalidation')
    {
        $sql    = 'SELECT * FROM deliveryPostcode WHERE 
               `deliveryPostcode` = "'.$_POST['pincode'].'"';
        $response = array();
        $query  = mysqli_query($conn,$sql);
        if(mysqli_num_rows($query) == 1)
        {
            $response['status'] = 'error';
            $response['message']= 'Pincode allready added';
            $response['body']   = array();
        } 
        else
        {
            $postCodeApiCall = file_get_contents('https://www.whizapi.com/api/v2/util/ui/in/indian-city-by-postal-code?pin='.$_POST['pincode'].'&project-app-key=db2tlltt913vgmihgz73ghcg');
            $postCodeApiCallResponse = json_decode($postCodeApiCall,true);
            if($postCodeApiCallResponse['ResponseMessage'] == 'OK')
            {
                $response['status'] = 'success';
                $response['message']= 'Pincode verified';
                $availabledata = "";
                $i=0;
                foreach($postCodeApiCallResponse['Data'] as $row)
                {
                    $availabledata .= '
                        <tbody id="'.$i.'ID"><tr class="odd gradeX">
							<td>'.$row['Pincode'].'</td>
                            <td>'.$row['Address'].'</td>
							<td>'.$row['City'].'</td>
							<td>'.$row['State'].'</td>
							<td><a href="javascript:void(0)" 
                            onclick="addpostcode(\''.$row['Pincode'].'\',\''.$row['Address'].'\',\''.$row['City'].'\',\''.$row['State'].'\',\''.$i++.'ID\')">Add</a></td></tr></tbody>';
                }
                $response['body']   = $availabledata;
            }
            else
            {
                $response['status'] = 'error';
                $response['message']= 'Pincode doesn\'t exists';
                $response['body']   = $postCodeApiCallResponse;
            }
        }
        echo json_encode($response);
    }
    if($_POST['submit'] == 'postcodeinsertion')
    {
        $queryString =  "INSERT INTO `deliveryPostcode` SET
                        `deliveryPostcode`      = '".$_POST['pincode']."',
                        `address`               = '".$_POST['Address']."',
                        `city`                  = '".$_POST['City']."',
                        `statename`             = '".$_POST['State']."',
                        `status`                = 'active'";
        mysqli_query($conn,$queryString);
    }
    if($_POST['submit'] == 'submitForSaveVendor')
    {
        $queryString =  "INSERT INTO `Restaurantlist` SET
                        `restaurentName`        = '".str_replace("'","\'",$_POST['Name'])."',
                        `restaurentStreet`      = '".$_POST['street']."',
                        `restaurentCity`        = '".$_POST['city']."',
                        `restaurentPinCode`     = '".$_POST['Pincode']."',
                        `restaurentDistrict`    = '".$_POST['district']."',
                        `restaurentLogo`        = '".$_POST['']."',
                        `restaurentType`        = '".$_POST['type']."',
                        `restaurentPhone`       = '".$_POST['phone']."',
                        `restaurentEmail`       = '".$_POST['email']."'";
        mysqli_query($conn,$queryString);
        header('Location:vendorlist.php');
    }
    if($_POST['submit'] == 'submitForSaveMenuCategory')
    {
        $queryString =  "INSERT INTO `MenuCategory` SET
                        `categoryName`          = '".str_replace("'","\'",$_POST['Name'])."',
                        `categoryDescription`   = '".$_POST['description']."'";
        mysqli_query($conn,$queryString);
        header('Location:menucategorylist.php');
    }
    if($_POST['submit'] == 'submitForUpdateVendor')
    {
        $queryString =  "UPDATE `Restaurantlist` SET
                        `restaurentName`        = '".$_POST['Name']."',
                        `restaurentStreet`      = '".$_POST['street']."',
                        `restaurentCity`        = '".$_POST['city']."',
                        `restaurentPinCode`     = '".$_POST['Pincode']."',
                        `restaurentDistrict`    = '".$_POST['district']."',
                        `restaurentLogo`        = '".$_POST['']."',
                        `restaurentType`        = '".$_POST['type']."',
                        `restaurentPhone`       = '".$_POST['phone']."',
                        `restaurentEmail`       = '".$_POST['email']."'
                        WHERE `id`=".$_POST['vendorID'];
        mysqli_query($conn,$queryString);
        header('Location:vendorlist.php');
    }
    if($_GET['action'] == 'logout')
    {
        unset($_SESSION['adminLogin']);
        session_destroy();
        header('Location:index.php');
    }
    if($_GET['action'] == 'deleteVendor')
    {
        if(trim($_GET['vendorID']) == "")
        {    
            header('Location:vendorlist.php');
            die();
        }
            
        $queryString = 'DELETE FROM `Restaurantlist` WHERE `id` = '.$_GET['vendorID'];
        mysqli_query($conn,$queryString);
        header('Location:vendorlist.php');
    }
} else {
    echo "error";
}
?>