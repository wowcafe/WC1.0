<?php
if(isset($_POST['submit']) || isset($_GET))
{
    include 'include/connect.php';
    
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
            $queryOfdeliverPostcode = mysqli_fetch_assoc($query);
            if($queryOfdeliverPostcode['status']=='deactive')
            {
                $response['status'] = 'error';
                $response['message']= 'Pincode added but deactivate. <a href="post.php?action=restorepostcode&postcodeId='.$queryOfdeliverPostcode['id'].'">Click here</a> to restore it.';
                $response['body']   = array();
            }
            else
            {
                $response['status'] = 'error';
                $response['message']= 'Pincode allready added';
                $response['body']   = array();
            }
            
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
        $target_file = "upload/vendorIimage/".basename($_FILES["vendorimage"]["name"]);
        move_uploaded_file($_FILES["vendorimage"]["tmp_name"], $target_file);
        
        $queryString =  "INSERT INTO `Vendorlist` SET
                        `vendorName`        = '".str_replace("'","\'",$_POST['Name'])."',
                        `vendorStreet`      = '".$_POST['street']."',
                        `vendorCity`        = '".$_POST['city']."',
                        `vendorPinCode`     = '".$_POST['Pincode']."',
                        `vendorDistrict`    = '".$_POST['district']."',
                        `vendorImage`        = '".$target_file."',
                        `vendorType`        = '".$_POST['type']."',
                        `vendorPhone`       = '".$_POST['phone']."',
                        `vendorWebsite`     = '".$_POST['webaddress']."',
                        `vendorEmail`       = '".$_POST['email']."'";
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
        echo $queryString =  "UPDATE `Vendorlist` SET
                        `".$_POST['field']."` = '".str_replace("'","\'",$_POST['value'])."'
                        WHERE `id`=".$_POST['id'];
        mysqli_query($conn,$queryString);
    }
    if($_POST['submit'] == 'sumbitForAddMenuToVendor')
    {
        $queryString =  "INSERT INTO `MenuDetails` SET
                        `menuName`          = '".str_replace("'","\'",$_POST['Name'])."',
                        `menuPrice`         = '".$_POST['Price']."',
                        `menuType`          = '".$_POST['type']."',
                        `menuDescription`   = '".$_POST['description']."',
                        `menuCategoryId`    = '".$_POST['categories']."',
                        `vendorId`          = '".$_POST['vendorId']."'";
        mysqli_query($conn,$queryString); 
        header('Location:vendorlist.php');
    }
    if($_POST['submit'] == 'sumbitForUpdateMenuToVendor')
    {
        $queryString =  "UPDATE `MenuDetails` SET
                        `menuName`          = '".str_replace("'","\'",$_POST['Name'])."',
                        `menuPrice`         = '".$_POST['Price']."',
                        `menuType`          = '".$_POST['type']."',
                        `menuDescription`   = '".$_POST['description']."',
                        `menuCategoryId`    = '".$_POST['categories']."'
                        WHERE `id`=".$_POST['menuId'];
        mysqli_query($conn,$queryString); 
        header('Location:vendorlist.php');
    }
    if($_GET['action'] == 'logout')
    {
        unset($_SESSION['adminLogin']);
        session_destroy();
        header('Location:index.php');
    }
    if($_GET['action'] == 'deletemenu')
    {
        if(trim($_GET['menuID']) == "")
        {    
            header('Location:vendorlist.php');
            die();
        }
        $queryString =  "UPDATE `MenuDetails` SET
                        `status`            = 'deactive'
                        WHERE `id`=".$_GET['menuID'];
        mysqli_query($conn,$queryString);
        header('Location:menulist.php?selectedcatid='.$_GET['selectedcatid'].'&selectedvendorid='.$_GET['selectedvendorid']);
    }
    if($_GET['action'] == 'restoremenu')
    {
        if(trim($_GET['menuID']) == "")
        {    
            header('Location:vendorlist.php');
            die();
        }
        $queryString =  "UPDATE `MenuDetails` SET
                        `status`            = 'active'
                        WHERE `id`=".$_GET['menuID'];
        mysqli_query($conn,$queryString);
        header('Location:menulist.php?selectedcatid='.$_GET['selectedcatid'].'&selectedvendorid='.$_GET['selectedvendorid']);
    }
    if($_GET['action'] == 'deletevendor')
    {
        if(trim($_GET['vendorID']) == "")
        {    
            header('Location:vendorlist.php');
            die();
        }
            
        $queryString = "UPDATE `Vendorlist` SET
                        `status`            = 'deactive'
                        WHERE `id`=".$_GET['vendorID'];
        mysqli_query($conn,$queryString);
        header('Location:vendorlist.php');
    }
    if($_GET['action'] == 'restorevendor')
    {
        if(trim($_GET['vendorID']) == "")
        {    
            header('Location:vendorlist.php');
            die();
        }
            
        $queryString = "UPDATE `Vendorlist` SET
                        `status`            = 'active'
                        WHERE `id`=".$_GET['vendorID'];
        mysqli_query($conn,$queryString);
        header('Location:vendorlist.php');
    }
    if($_GET['action'] == 'deletemenucategory')
    {
        if(trim($_GET['catID']) == "")
        {    
            header('Location:menucategorylist.php');
            die();
        }
            
        $queryString = "UPDATE `MenuCategory` SET
                        `status`            = 'deactive'
                        WHERE `id`=".$_GET['catID'];
        mysqli_query($conn,$queryString);
        header('Location:menucategorylist.php');
    }
    if($_GET['action'] == 'restoremenucategory')
    {
        if(trim($_GET['catID']) == "")
        {    
            header('Location:menucategorylist.php');
            die();
        }
            
        $queryString = "UPDATE `MenuCategory` SET
                        `status`            = 'active'
                        WHERE `id`=".$_GET['catID'];
        mysqli_query($conn,$queryString);
        header('Location:menucategorylist.php');
    }
    if($_GET['action'] == 'deletepostcode')
    {
        if(trim($_GET['postcodeId']) == "")
        {    
            header('Location:postcodelist.php');
            die();
        }
            
        $queryString = "UPDATE `deliveryPostcode` SET
                        `status`            = 'deactive'
                        WHERE `id`=".$_GET['postcodeId'];
        mysqli_query($conn,$queryString);
        header('Location:postcodelist.php');
    }
    if($_GET['action'] == 'restorepostcode')
    {
        if(trim($_GET['postcodeId']) == "")
        {    
            header('Location:postcodelist.php');
            die();
        }
            
        $queryString = "UPDATE `deliveryPostcode` SET
                        `status`            = 'active'
                        WHERE `id`=".$_GET['postcodeId'];
        mysqli_query($conn,$queryString);
        header('Location:postcodelist.php');
    }
} else {
    echo "error";
}
?>