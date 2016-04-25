<?php include 'include/header.php'; ?>
<script type="text/javascript">
function errorcheck(inputType,inputName)
{
    if (inputType.value == null || inputType.value == "")
        $("input[name="+inputName+"]").addClass('error');
    else 
        $("input[name="+inputName+"]").removeClass('error');
}
function validateForm() {
    var Pincode     = document.forms["addvendor"]["Pincode"];
    errorcheck(Pincode,'Pincode');
    
    if($("input").hasClass('error'))
        return false;
}
var specialKeys = new Array();
specialKeys.push(8); //Backspace
function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode;
               var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            
            
            return ret;
        }
function postcodevalidation(val){
    if(val.length == 6)
            {
                $.ajax({ 
            		type:'POST',
            		data:{pincode:val,submit:'postcodevalidation'},
            		url:"post.php",
            		success:function(data){
            			var jsObject = JSON.parse(data);
                        if(jsObject['status'] == 'error')
                        {
                            $(".postCodevalidationError").show().html(jsObject['message']);
                            $("#getDataFromPincode").find('tbody:gt(0)').remove();
                            $("#getDataFromPincode tbody:first").show();
                        }
                        else
                        {
                            $(".postCodevalidationError").hide();
                            $("#getDataFromPincode").find('tbody:gt(0)').remove();
                            $("#getDataFromPincode tbody:first").hide();
                            $("#getDataFromPincode").append(jsObject['body']);
                        }
            		}
            	});
            }
}
function addpostcode(pincode,Address,City,State,identifier){
    $.ajax({ 
		type:'POST',
		data:{pincode:pincode,Address:Address,City:City,State:State,submit:'postcodeinsertion'},
		url:"post.php",
		success:function(data){
			$("#"+identifier).remove();
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
            <div class="box round first fullpage">
                <h2>Add new vendor</h2>
                <div class="block ">
                    <table class="form">
                        <tr>
                            <td style="width: 150px;">
                                <label>Enter new pincode</label>
                            </td>
                            <td style="width: 200px;">
                                <input type="text" name="Pincode" onkeyup="postcodevalidation(this.value)" onkeypress="return IsNumeric(event);" onpaste="return false;" ondrop = "return false;" maxlength="6"/>
                            </td>
                            <td>
                                <span class="error postCodevalidationError" style="display: none;">This is a required field.</span>
                            </td>
                        </tr>
                    </table>
                    <table class="data display datatable" id="getDataFromPincode">
    					<thead>
    						<tr>
                                <th>Postcode</th>
    							<th>Address</th>
                                <th>City</th>
                                <th>statename</th>
                                <th>+</th>
    						</tr>
    					</thead>
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
