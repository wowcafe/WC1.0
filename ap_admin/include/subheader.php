<div class="grid_12 header-repeat">
    <div id="branding">
        <div class="floatleft">
            <img src="img/logo-m.png" alt="Logo" style="width: 17%;" /></div>
        <div class="floatright">
            <div class="floatleft marginleft10">
                <ul class="inline-ul floatleft">
                    <li>Hello <?php echo $_SESSION['username'] ?></li>
                    <li><a href="post.php?action=logout">Logout</a></li>
                </ul>
            </div>
            <a href="javascript:history.go(-1)">back</a>
        </div>
        <div class="clear">
        </div>
    </div>
</div>