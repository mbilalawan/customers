<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(($_SESSION['isAdminC']==1) || ($_SESSION['isSUserC']==1) || ($_SESSION['isVisitorC']==1) || ($_SESSION['isPVisitorC']==1) || ($_SESSION['isUserC']==1) || ($_SESSION['isDailyC']==1) || ($_SESSION['isSecurityUser']==1))
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Customers Management System</title>
<link href="style.css" rel="stylesheet" type="text/css" />

<style type="text/css">

</style>

</head>

<body style="min-width: 600px;">

<div class="container" style="min-width: 600px;">
    <?php include 'welcome.php'; ?>
  <div style="font-weight: bold; text-align: center; font-size: x-large; padding-top: 2%;"><a href="usermain.php"><img src="designimages/logo.png" alt="Customers Management System" name="Customers Management System" id="Insert_logo"  /></a> 
    </div>
  <div class="content" style="min-width: 580px;padding: 10px !important;">

    <div style="font-weight: bold; text-align: center; font-size: xx-large; ">
     <span style="text-align:center" >Customers Management System</span>
     
     <br />
     <span style="font-size:35px;text-align:center" >Main Page</span>
    </div>
    
<div class="containerusermain" style="padding-top: 35px !important;margin-bottom: 39px !important;">
        <?php 
 include 'header_1.php'; 
 ?>
    </div>

</div>
    
    
    
  <div class="footer">
    
    <!-- end .footer --></div>
    
    <div class="header2" style="    background-color: #ffffff;">
    <div style="font-weight: bold; text-align: center; font-size: x-large; padding-top: 3%; padding-bottom:2%;">
   
	</div>
  </div>
  
  
  <div class="welcome dontprint">
     <p style="font-size: small; text-align: center; direction: rtl;"> 
       
     <span style="color: aqua; font-size: large; text-decoration: none;">
            <?//=$_SESSION['username_C'];?> </span>
     <A href="adminLogin.php" style="color: white; font-size: large; text-decoration: none;">Exit</A>

     </p>
 </div>
 
 
  <!-- end .container --></div>
</body>
</html>
<?php }
else {
Header( "Location: adminLogin.php" ); //echo "Invalid User Name or Password";
}
?>