<div class="grid_2">
    <div class="box sidemenu">
        <div class="block" id="section-menu">
            <ul class="section menu">
                <li><a class="menuitem">Vendor</a>
                    <ul class="submenu">
                        <li>
                            <a <?php echo (basename($_SERVER['PHP_SELF']) == 'vendorlist.php')? 'class="act"' : ''; ?> href="vendorlist.php">View All</a> </li>
                        <li><a <?php echo (basename($_SERVER['PHP_SELF']) == 'add_vendor.php')? 'class="act"' : ''; ?> href="add_vendor.php">Add</a> </li>
                        <li><a <?php echo (basename($_SERVER['PHP_SELF']) == 'trash_vendorlist.php')? 'class="act"' : ''; ?> href="trash_vendorlist.php">Removed</a> </li>
                    </ul>
                </li>
                <li><a class="menuitem">Customer</a>
                    <ul class="submenu">
                        <li><a <?php echo (basename($_SERVER['PHP_SELF']) == 'customerlist.php')? 'class="act"' : ''; ?> href="customerlist.php">View all</a> </li>
                    </ul>
                </li>
                <li><a class="menuitem">Postcode</a>
                    <ul class="submenu">
                        <li><a <?php echo (basename($_SERVER['PHP_SELF']) == 'postcodelist.php')? 'class="act"' : ''; ?> href="postcodelist.php">View all</a> </li>
                        <li><a <?php echo (basename($_SERVER['PHP_SELF']) == 'add_postcode.php')? 'class="act"' : ''; ?> href="add_postcode.php">Add</a> </li>
                    </ul>
                </li>
                <li><a class="menuitem">Menu category</a>
                    <ul class="submenu">
                        <li><a <?php echo (basename($_SERVER['PHP_SELF']) == 'menucategorylist.php')? 'class="act"' : ''; ?> href="menucategorylist.php">View all</a> </li>
                        <li><a <?php echo (basename($_SERVER['PHP_SELF']) == 'add_menucategory.php')? 'class="act"' : ''; ?> href="add_menucategory.php">Add</a> </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>