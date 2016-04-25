<?php include 'include/header.php';
$CATwhere = "";
$RESwhere = "";
if(isset($_GET['selectedcatid']) && $_GET['selectedcatid']!="")
    $CATwhere = ' AND menu.`menuCategoryId` = '.$_GET['selectedcatid'];

if(isset($_GET['selectedvendorid']) && $_GET['selectedvendorid']!="")
    $RESwhere = ' AND menu.`vendorId` = '.$_GET['selectedvendorid'];


$sql = 'SELECT menu.`id`, 
               menu.`menuName`,
               menu.`menuPrice`,
               menu.`menuType`,
               menu.`menuCategoryId`,
               menu.`vendorId`,
               category.categoryName as `category`, 
               vendor.vendorName as `vendor` 
               FROM 
               `MenuDetails` as `menu`, 
               `MenuCategory` as `category` , 
               `Vendorlist` as `vendor` 
               WHERE 
               menu.`menuCategoryId` = category.`id` 
               AND
               menu.`status` = "deactive"
               AND                                   
               vendor.`id` = menu.`vendorId`'.$CATwhere.$RESwhere;
$query = mysqli_query($conn,$sql);

$sqlOfVendor       = 'SELECT * FROM `Vendorlist` WHERE `id`='.$_GET['selectedvendorid'];
$queryOfVendor     = mysqli_query($conn,$sqlOfVendor);
$rowOfVendor       = mysqli_fetch_assoc($queryOfVendor);

$sqlOfAllCategory       = 'SELECT * FROM `MenuCategory` WHERE `id`='.$_GET['selectedcatid'];
$queryOfAllCategory     = mysqli_query($conn,$sqlOfAllCategory);
$rowOfAllCategory       = mysqli_fetch_assoc($queryOfAllCategory);
?>
<body>
    <div class="container_12">
        <?php include 'include/subheader.php'; ?>
        <div class="clear">
        </div>
        <?php include 'include/navpanel.php'; ?>
        <div class="clear">
        </div>
        <?php include 'include/sidepanel.php'; ?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2><label><?php echo $rowOfVendor['vendorName']; ?></label> : <i><?php echo $rowOfAllCategory['categoryName']; ?></i></h2>
                <div class="block">
                <a href="add_menu.php?selectedcatid=<?php echo $_GET['selectedcatid']?>&selectedvendorid=<?php echo $_GET['selectedvendorid']; ?>" class="btn-icon btn-grey btn-plus addButtonForVendor"><span></span>Add</a>
                    <table class="data display datatable" id="example">
					<thead>
    						<tr>
                                <th>Name</th>
    							<th>Price</th>
                                <th>Type</th>
                                <th>Restore</th>
    						</tr>
    					</thead>
					<tbody>
                        <?php while($row = mysqli_fetch_assoc($query)) { ?>
						<tr class="odd gradeX">
							<td><?php echo $row['menuName'] ?></td>
                            <td><?php echo $row['menuPrice'] ?></td>
							<td><?php echo $row['menuType'] ?></td>                            
							<td><a onclick="return confirm('Are you sure you want to restore the menu?')" href="post.php?action=restoremenu&menuID=<?php echo $row['id'] ?>&selectedcatid=<?php echo $_GET['selectedcatid'] ?>&selectedvendorid=<?php echo $_GET['selectedvendorid'] ?>">Restore</td>
						</tr>
                        <?php } ?>
					</tbody>
				</table>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
    <div class="clear">
    </div>
    <div id="site_info">
        <p>
            Copyright <a href="#">wowcafe.in Admin</a>. All Rights Reserved.
        </p>
    </div>
</body>
</html>
