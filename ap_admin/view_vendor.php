<?php include 'include/header.php';
$CATwhere = "";
$RESwhere = "";
if(isset($_GET['selectedvendorid']) && $_GET['selectedvendorid']!="")
    $RESwhere = ' AND menu.`vendorId` = '.$_GET['selectedvendorid'];


    $sqlOfCategories =  'SELECT DISTINCT menu.`menuCategoryId`,
                        category.`categoryName` as `categoryName`
                        FROM 
                        `MenuDetails`    as `menu`, 
                        `MenuCategory`   as `category` , 
                        `Vendorlist`    as `vendor` 
                        WHERE 
                        menu.`menuCategoryId` = category.`id` 
                        AND                                   
                        vendor.`id` = menu.`vendorId`'.$RESwhere;
                        
    $sqlOfVendor = 'SELECT * FROM `Vendorlist` WHERE `id`='.$_GET['selectedvendorid'];
    
$queryOfCategories = mysqli_query($conn,$sqlOfCategories);
$queryOfVendor     = mysqli_query($conn,$sqlOfVendor);
$rowOfVendor       = mysqli_fetch_assoc($queryOfVendor);
?>
<script type="text/javascript">
$(function(){
    $(".instantEdit").click(function(){
       var $this = $(this);
       var editText = $this.prev().text();
       $this.prev().remove();
       $this.parent().prepend('<input type="text" value="'+editText+'" name="'+$this.attr("id")+'" />');
       $this.addClass('saveeditlink');
       $this.next().removeClass('saveeditlink');
    });
    $(".instantSave").click(function(){
       var $this = $(this);
       var $parent = $this.parent();
       var editedText = $parent.find('input[type="text"]').val();
       var editedField = $parent.find('input[type="text"]').attr('name');
       saveinlinedetails(editedField,editedText);
       $parent.find('input[type="text"]').remove();
       $parent.prepend('<label>'+editedText+'</label>');
       $this.addClass('saveeditlink');
       $this.prev().removeClass('saveeditlink');
    });
})
function saveinlinedetails(editedField,editedText)
{
    $.ajax({ 
		type:'POST',
		data:{field:editedField,value:editedText,id:<?php echo $_GET['selectedvendorid'] ?>,submit:'submitForUpdateVendor'},
		url:"post.php",
		success:function(data){
			
		}
	});
}
</script>
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
            <div class="box round first">
                <h2>
                    <label><?php echo $rowOfVendor['vendorName']; ?></label>
                    <a class="instantEdit" id="vendorName">edit</a>
                    <a class="instantSave saveeditlink">save</a>
                </h2>
                <div class="block blockextension">
                    <p class="start startextension">
                        <img src="<?php echo $rowOfVendor['vendorImage']; ?>" alt="Ginger" class="left" /></p>
                        <h3 class="headerextension">Address</h3>
                    <ol class="vendorDetails">
                        <li>
                            <p class="labelIdentifier">Street : </p>
                            <label><?php echo $rowOfVendor['vendorStreet']; ?></label>
                            <a class="instantEdit" id="vendorStreet">edit</a>
                            <a class="instantSave saveeditlink">save</a>
                        </li>
                        <li>
                            <p class="labelIdentifier">City : </p>
                            <label><?php echo $rowOfVendor['vendorCity']; ?></label>
                            <a class="instantEdit" id="vendorCity">edit</a>
                            <a class="instantSave saveeditlink">save</a>
                        </li>
                        <li>
                            <p class="labelIdentifier">Pincode : </p>
                            <label><?php echo $rowOfVendor['vendorPinCode']; ?></label>
                            <a class="instantEdit" id="vendorPinCode">edit</a>
                            <a class="instantSave saveeditlink">save</a>
                        </li>
                        <li>
                            <p class="labelIdentifier">District : </p>
                            <label><?php echo $rowOfVendor['vendorDistrict']; ?></label>
                            <a class="instantEdit" id="vendorDistrict">edit</a>
                            <a class="instantSave saveeditlink">save</a>
                        </li>
                    </ol>
                    <h3 class="headerextension">Others</h3>
                    <ol class="vendorDetails">
                        <li>
                            <p class="labelIdentifier">Phone : </p>
                            <label><?php echo $rowOfVendor['vendorPhone']; ?></label>
                            <a class="instantEdit" id="vendorPhone">edit</a>
                            <a class="instantSave saveeditlink">save</a>
                        </li>
                        <li>
                            <p class="labelIdentifier">Email : </p>
                            <label><?php echo $rowOfVendor['vendorEmail']; ?></label>
                            <a class="instantEdit" id="vendorEmail">edit</a>
                            <a class="instantSave saveeditlink">save</a>
                        </li>
                        <li>
                            <p class="labelIdentifier">Website : </p>
                            <label><?php echo $rowOfVendor['vendorWebsite']; ?></label>
                            <a class="instantEdit" id="vendorWebsite">edit</a>
                            <a class="instantSave saveeditlink">save</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Categories</h2>
                <div class="block">
                <a href="add_menu.php?selectedvendorid=<?php echo $_GET['selectedvendorid']; ?>" class="btn-icon btn-grey btn-plus addButtonForVendor"><span></span>Add Menu</a>
                    <table class="data display datatable" id="example">
					<thead>
    						<tr>
                                <th>Category Name</th>
    							<th>View Menu's</th>
                                <th>Trash</th>
    						</tr>
    					</thead>
					<tbody>
                        <?php while($rowOfCategories = mysqli_fetch_assoc($queryOfCategories)) { ?>
						<tr class="odd gradeX">
							<td><?php echo $rowOfCategories['categoryName'] ?></td>
                            <td><a href="menulist.php?selectedcatid=<?php echo $rowOfCategories['menuCategoryId']?>&selectedvendorid=<?php echo $_GET['selectedvendorid']; ?>"> View Menu's</a></td>
                            <td><a href="trash_menulist.php?selectedcatid=<?php echo $rowOfCategories['menuCategoryId']?>&selectedvendorid=<?php echo $_GET['selectedvendorid']; ?>"> Removed</a></td>
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
