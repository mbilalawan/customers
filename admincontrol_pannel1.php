<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include "db_config.php";
session_start();
$_SESSION['isAdminC']=1;
if($_SESSION['isAdminC']==1)
{ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Schedule - Admin Control Panel</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">


<style type="text/css">
</style>
 
<script src="selectdata.js"></script>

<SCRIPT LANGUAGE=JAVASCRIPT>
function verify(tid){
     switch(tid) {
         case "del_user":
           msg = "This will delete user from Database";
           return confirm(msg);
           break;
	}
}
</SCRIPT>
<SCRIPT LANGUAGE=JAVASCRIPT>

</SCRIPT>

</head>

<body>

<div class="container">
  <?php include 'welcome.php'; ?>
  <?php include 'header.php'; ?>
  <div class="content">
<div>
          <p align="center">
     Admin Control Panel</p>
     </div>
      <?php include 'header_1.php'; ?>
<?php
include 'dbConnectionPDO.class.php';
$pdo = dbConnectionPDO::connect();  
		global $pdo;

	function update_data(){
	}
	//$p_id=$HTTP_REQUEST_VARS[$p_id];
	function deleteuser($username){
		global $pdo;		
		$count=$pdo->prepare("DELETE FROM tbluser WHERE user_name=:username");
		$count->bindParam(":username",$username,PDO::PARAM_STR);
		$count->execute();
		
		echo $username;
			echo("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('User is Deleted')
			</SCRIPT>"); 
			?>
			<SCRIPT LANGUAGE='JavaScript'>
			document.location.href = "<?= $_SERVER['PHP_SELF']?>";
			</SCRIPT>
			<?php
	}

	function adduser($uname, $pass, $type){
				global $pdo;		
		$query= "SELECT * from tbluser where user_name = :uname";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
		$stmt->execute();
		//$row = $stmt->fetch(PDO::FETCH_ASSOC);		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))		
		{
		echo("<SCRIPT LANGUAGE='JavaScript'>
window.alert('User with this name already exists')
</SCRIPT>"); 
		}
		else
		{
		$pass = md5($pass);
	
		$query="INSERT INTO tbluser ( user_id, user_name, user_password, user_type) VALUES ( NULL , :uname, :pass, :type)";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
		$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
		$stmt->bindParam(':type', $type, PDO::PARAM_STR);
		$stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		
		echo("<SCRIPT LANGUAGE='JavaScript'>
window.alert('Database Has Been Updated')
</SCRIPT>"); 
}

?>
			<SCRIPT LANGUAGE='JavaScript'>
			document.location.href = "<?= $_SERVER['PHP_SELF']?>";
			</SCRIPT>
			<?php
	}
	
?>
<form id="myForm" method="post" action="admincontrol_pannel1.php">
<table width="900" border="0" cellpadding="6" cellspacing="0" align="center">

  <tr valign="top">
    <td width="333"><fieldset class="directions">
    <table width="242" border="0" cellspacing="0" cellpadding="4" align="center">
	
     <tr valign="top" class="next_item">
            <td class="body_textBold" colspan="2" style="text-align: center; font-weight: bold;">User Management:</td>
        </tr> <tr valign="top">
          <td colspan="2" class="body_textBold"><div align="center" style="color: green;"><strong> Add User: </strong></div></td>
      </tr>
      <tr valign="top">
       <td class="body_textBold">  <div align="right">User Name:</div></td>
        <td class="body_text"><input type="text" name="username" tabindex="1"></td>
      </tr>
      <tr valign="top">
        <td class="body_textBold"><div align="right">Password:</div></td>
        <td class="body_text"><input type="text" name="password" tabindex="2" autocomplete="off"></td>
      </tr>
	   <tr valign="top">
        <td class="body_textBold"><div align="right">User Type:</div></td>
        <td class="body_text"><p>
		  <label>
            <input name="rtgroup" type="radio" value="superuser" tabindex="3">
            User</label>
          <br>
          <label>
            <input type="radio" name="rtgroup" value="admin">
            Admin</label>
          <br>            
        </p></td>
	   </tr>
      <tr valign="top">
        <td class="body_textBold">&nbsp;</td>
        <td class="body_text"><input name="submit_user" type="submit" id="submit_user" tabindex="4" value="Submit"></td>
      </tr>

	  <tr valign="top">
        <td class="next_item">&nbsp;</td>
        <td class="body_text"></td>
      </tr>
        <tr valign="top">
            <td class="body_textBold" colspan="2"><div style="text-align: center; color: red;"><strong>Delete User:</strong></div></td>
          </tr>
	  <tr valign="top">
              <td colspan="2" class="body_text" style="text-align: center;"><select name="selectuser" tabindex="13" id="selectuser">
          <?php  $g_query="SELECT user_name FROM tbluser order by user_name;";
		$g_result=mysqli_query($dbh,$g_query) or die (mysqli_query());
		while($g_row=mysqli_fetch_array($g_result)){
		?>
          <option value="<?= $g_row['user_name']?>">
            <?= $g_row['user_name']?>
            </option>
          <?php
	
		 } // end while		  
		   ?>          
        </select></td>
      </tr>
        <tr valign="top" class="next_item">
        
        <td class="body_text" colspan="2" style="text-align: center;"><input name="del_user" type="submit" id="del_user" tabindex="14" value="Delete" onClick="return verify(this.id);"></td>
</tr>

<tr valign="top">
        <td class="body_textBold">&nbsp;</td>
        <td class="body_text">&nbsp;</td>
</tr>

    </table></fieldset>
      </td>
      <td width="352"><fieldset class="directions">

    <table width="200" border="0" cellspacing="0" cellpadding="4" align="center">
      
        <tr valign="top" class="next_item">
            <td class="body_textBold" colspan="2" style="text-align: center; font-weight: bold;">User Online:</td>
        </tr>
        <tr valign="top" class="next_item">
            <td class="body_text" >User_Name</td>
            
        </tr>
          
              <?php  $g_query="SELECT distinct username FROM usersonline;";
		$g_result=mysqli_query($dbh,$g_query) or die (mysqli_query());
		while($g_row=mysqli_fetch_array($g_result)){
		?>
            <tr valign="top" class="next_item_thin">
                <td class="small_text"><b><?= $g_row['username']?></b></td>
              
            </tr>
          <?php
	
		 } // end while
		  

		   ?> 

    </table>
	</fieldset></td>
	<td width="352"><fieldset class="directions">

    <table width="200" border="0" cellspacing="0" cellpadding="4" align="center">

        <tr valign="top" class="next_item">
            <td class="body_textBold" colspan="2" style="text-align: center; font-weight: bold;">User Details:</td>
        </tr>
        <tr valign="top" class="next_item">
            <td class="body_text">Login</td>
            <td class="body_text">Role</td>
        </tr>
          
              <?php  $g_query="SELECT user_name, user_type FROM tbluser order by user_type;";
		$g_result=mysqli_query($dbh,$g_query) or die (mysqli_query());
		while($g_row=mysqli_fetch_array($g_result)){
		?>
            <tr valign="top" class="next_item_thin">
                <td class="small_text"><b><?= $g_row['user_name']?></b></td>
              <td class="small_text"><?= $g_row['user_type']?></td>
            </tr>
          <?php
	
		 } // end while
		  
		   ?> 

    </table>
	</fieldset></td>
	
	</tr>   
  <TR>
    <TD colspan="2">&nbsp;</TD>
  </TR>
  <TR>
  
</table> <?php include 'header_1.php'; ?>
<p>
  <map name="home">
    <area shape="rect" coords="14,19,123,69" href="../index.htm">
  </map>
</p>

<?php


if (isset($_POST['submit_user'])){

if($_POST['submit_user'] == "Submit") {
//echo ($_POST['rtgroup']);
	//echo "submit pressed";
	if(($_POST['username'] != "")&&($_POST['password'] != "")){
		//echo "submit pressed1s";
		adduser ($_POST['username'], $_POST['password'], $_POST['rtgroup']);

		}
		
}} 
if (isset($_POST['del_user'])){
if($_POST['del_user'] == "Delete") {
//echo ($_POST['rsearch']);
	//echo "save pressed";
	
		deleteuser ($_POST['selectuser']);
		//echo $_POST['selectuser'];			
}}

?>
</form>
</div>
  <div class="footer">
    
    <!-- end .footer --></div>
  <!-- end .container --></div>
</BODY>

</HTML>
<?php }
else {
Header( "Location: adminLogin.php" ); //echo "Invalid User Name or Password";
}
?>