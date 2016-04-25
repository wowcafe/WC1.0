<?php include 'include/header.php'; 
$sql = 'SELECT * FROM `deliveryPostcode` WHERE `status` = "deactive"';
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
                <a href="add_postcode.php" class="btn-icon btn-grey btn-plus addButtonForVendor"><span></span>Add</a>
                    <table class="data display datatable" id="example">
					<thead>
    						<tr>
                                <th>Postcode</th>
    							<th>Address</th>
                                <th>City</th>
                                <th>statename</th> 
                                <th>Status</th>
                                <th>Restore</th>
    						</tr>
    					</thead>
					<tbody>
                        <?php while($row = mysqli_fetch_assoc($query)) { ?>
						<tr class="odd gradeX">
							<td><?php echo $row['deliveryPostcode'] ?></td>
                            <td><?php echo $row['address'] ?></td>
							<td><?php echo $row['city'] ?></td>
							<td><?php echo $row['statename'] ?></td>
                            <td><?php echo $row['status'] ?></td>
							<td><a onclick="return confirm('Are you sure, you want to restore it?')" href="post.php?action=restorepostcode&postcodeId=<?php echo $row['id'] ?>">Restore</td>
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
