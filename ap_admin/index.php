<?php include 'include/formheader.php'; ?>
<body>
    <div class="container_12">
        
        <div class="clear">
        </div>
        <div class="grid_12">
            <ul class="nav main">
            </ul>
        </div>
        <div class="clear">
        </div>
        <div class="grid_12">
            <div class="box round first fullpage">
                <h2 class="loginHeader">Wowcafe.in Login</h2>
                <div class="block ">
                    <form action="post.php" method="post">
                    <table class="form">
                        <tr>
                            <td class="col1">
                                <label>User Name</label>
                            </td>
                            <td class="col2">
                                <input type="text" name="username" />
                            </td>
                        </tr>
                        <tr>
                            <td class="col1">
                                <label>Password</label>
                            </td>
                            <td class="col2">
                                <input type="password" name="password" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-small" name="submit" value="submitForLogin">Small Button</button>
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="clear">
        </div>
    </div>
    <div class="clear">
    </div>
    <div id="site_info">
        <p>
            Copyright <a href="www.wowcafe.in">Wowcafe admin</a>. All Rights Reserved.
        </p>
    </div>
</body>
</html>
