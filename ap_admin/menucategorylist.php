<?php include 'include/header.php'; 
$sql = 'SELECT * FROM `MenuCategory`
        WHERE `status`="active"';
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
                <a href="add_menucategory.php" class="btn-icon btn-grey btn-plus addButtonForVendor"><span></span>Add</a>
                    <table class="data display datatable" id="example">
					<thead>
    						<tr>
                                <th>Name</th>
    							<th>Description</th>
                                <th>Edit</th>
                                <th>Delete</th>
    						</tr>
    					</thead>
					<tbody>
                        <?php while($row = mysqli_fetch_assoc($query)) { ?>
						<tr class="odd gradeX">
							<td><?php echo $row['categoryName'] ?></td>
                            <td><?php echo $row['categoryDescription'] ?></td>
							<td><a href="edit_menucategory.php?menuID=<?php echo $row['id'] ?>">Edit</a></td>
                       	    <td><a href="post.php?action=deletemenucategory&catID=<?php echo $row['id'] ?>">Edit</a></td>
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
