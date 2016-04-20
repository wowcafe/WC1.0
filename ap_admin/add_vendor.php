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
    var Name        = document.forms["addvendor"]["Name"];
    var Pincode     = document.forms["addvendor"]["Pincode"];
    var street      = document.forms["addvendor"]["street"];
    var city        = document.forms["addvendor"]["city"];
    var district    = document.forms["addvendor"]["district"];
    var type        = document.forms["addvendor"]["type"];
    var phone       = document.forms["addvendor"]["phone"];
    var email       = document.forms["addvendor"]["email"];
    
    errorcheck(Name,'Name');
    errorcheck(Pincode,'Pincode');
    errorcheck(street,'street');
    errorcheck(city,'city');
    errorcheck(district,'district');
    errorcheck(type,'type');
    errorcheck(phone,'phone');
    errorcheck(email,'email');
    
    if($("input").hasClass('error'))
        return false;
}
var specialKeys = new Array();
specialKeys.push(8); //Backspace
function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            return ret;
        }

</script>
<body>
    <div class="container_12">
        <div class="grid_12 header-repeat">
            <div id="branding">
                <div class="floatleft">
                    <img src="img/logo.png" alt="Logo" /></div>
                <div class="floatright">
                    <div class="floatleft">
                        <img src="img/img-profile.jpg" alt="Profile Pic" /></div>
                    <div class="floatleft marginleft10">
                        <ul class="inline-ul floatleft">
                            <li>Hello <?php echo $_SESSION['username'] ?></li>
                            <li><a href="#">Config</a></li>
                            <li><a href="post.php?action=logout">Logout</a></li>
                        </ul>
                        <br />
                        <span class="small grey">Last Login: 3 hours ago</span>
                    </div>
                </div>
                <div class="clear">
                </div>
            </div>
        </div>
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
                    <form name="addvendor" action="post.php" method="POST" onsubmit="return validateForm()">
                    <table class="form">
                        <tr>
                            <td class="col1">
                                <label>Name</label>
                            </td>
                            <td class="col2">
                                <input type="text" name="Name" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Pincode</label>
                            </td>
                            <td>
                                <input type="text" name="Pincode" onkeypress="return IsNumeric(event);" onpaste="return false;" ondrop = "return false;"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Street</label>
                            </td>
                            <td>
                                <input type="text" name="street" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>City</label>
                            </td>
                            <td>
                                <input type="text" name="city" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>District</label>
                            </td>
                            <td>
                                <input type="text" name="district" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Type</label>
                            </td>
                            <td>
                                <input type="text" name="type" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Phone</label>
                            </td>
                            <td>
                                <input type="text" name="phone" onkeypress="return IsNumeric(event);" onpaste="return false;" ondrop = "return false;"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Email</label>
                            </td>
                            <td>
                                <input type="text" name="email" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="btn" name="submit" value="submitForSaveVendor">Save</button>
                            </td>
                        </tr>
                    </table>
                    </form>
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
