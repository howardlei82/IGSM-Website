<?php
function mrt_sub0(){

mrt_wpss_menu_head('WP - Security Scan');?>

          <div style="height:299px">
<table width="100%"  border="0" cellspacing="0" cellpadding="3" style="text-align:center;">
         <tr>
        <th style="border:0px;"><b>Name</b></th>
        <th style="border:0px;"><b>File/Dir</b></th>
        <th style="border:0px;"><b>Needed Chmod</b></th>
        <th style="border:0px;"><b>Current Chmod</b></th>
  <!--      <th style="border:0px;"><b>Change Permissions</b></th>-->
    </tr>
    <?php
        check_perms("root directory","../","0755");
        check_perms("wp-includes/","../wp-includes","0755");
        check_perms(".htaccess","../.htaccess","0644");
        check_perms("wp-admin/index.php","index.php","0644");
        check_perms("wp-admin/js/","js/","0755");
        check_perms("wp-content/themes/","../wp-content/themes","0755");
        check_perms("wp-content/plugins/","../wp-content/plugins","0755");
        check_perms("wp-admin/","../wp-admin","0755");
        check_perms("wp-content/","../wp-content","0755");
    ?>
</table>


          </div>
<?php
   mrt_wpss_menu_footer();
 } ?>
