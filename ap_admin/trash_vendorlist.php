<?php include 'include/header.php'; 
$sql = 'SELECT 
        `id`,
        `vendorName`,
        `vendorPinCode`,
        `vendorPhone`,
        `vendorEmail`,
        `vendorImage`
        FROM `Vendorlist`
        WHERE `status`="deactive"
        ORDER BY `order_index` ASC';
$query = mysqli_query($conn,$sql);
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
                <h2>
                    Vendors</h2>
                <div class="block">
                <a href="add_vendor.php" class="btn-icon btn-grey btn-plus addButtonForVendor"><span></span>Add</a>
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
                            <th>Image</th>
                            <th>Name</th>
							<th>PinCode</th>
							<th>Phone</th>
							<th>Email</th>
                            <th>Restore</th>
						</tr>
					</thead>
					<tbody>
                        <?php while($row = mysqli_fetch_assoc($query)) { ?>
						<tr class="odd gradeX">
							<td><img src="<?php echo $row['vendorImage'] ?>" height="30" width="30" /></td>
                            <td><?php echo $row['vendorName'] ?></td>
							<td><?php echo $row['vendorPinCode'] ?></td>
							<td><?php echo $row['vendorPhone'] ?></td>
							<td><?php echo $row['vendorEmail'] ?></td>
                            <td><a onclick="return confirm('Are you sure you want to restore it?')" href="post.php?action=restorevendor&vendorID=<?php echo $row['id'] ?>">Restore</td>
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
