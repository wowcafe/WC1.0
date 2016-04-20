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
    
    errorcheck(Name,'Name');
    
    if($("input").hasClass('error'))
        return false;
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
                    <form name="addmenucategory" action="post.php" method="POST" onsubmit="return validateForm()">
                    <table class="form">
                        <tr>
                            <td class="col1">
                                <label>Category Name *</label>
                            </td>
                            <td class="col2">
                                <input type="text" name="Name" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <label>Description</label>
                            </td>
                            <td>
                                <input type="text" name="description" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="btn" name="submit" value="submitForSaveMenuCategory">Save</button>
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
