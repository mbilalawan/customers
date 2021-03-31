<div class="header_1">
<?php 
	if(($_SESSION['isAdminC']==1) || ($_SESSION['isSUserC']==1))
	{
	?>
    <div>
        <A class="showbtnbig" href="usermain.php">Main Page</A> 
	<?php if($_SESSION['isAdminC']==1) { ?>
        <A class="showbtnbig" href="admincontrol_pannel1.php" nowrap>Settings</A>
		<?php } ?>
		<A class="showbtnbig" href="admincontrol_pannelftpNEW.php?g_type=1" style="width:125px">Add Customer</A>
        <A class="showbtnbig" href="reportd.php?f_id=1" >Report</A>
		<A class="showbtnbig" href="adminLogin.php" nowrap>Exit</A>                     
    </div>
	<?php }
		
	  ?>
      
      
      </div>