
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Customer Management System</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="apple-touch-icon" sizes="72x72" href="designimages/logo.png" />

</head>

<body style="min-width: 600px;">

<div class="container" style="min-width: 500px;">
<div class="header1_login" style="min-width: 500px; padding-bottom: 228px;">
<div class="content" style="min-width: 482px;">
  
<?php
ini_set('display_errors',0);
ini_set('display_startup_errors',0);
error_reporting(0);
session_start();

include 'dbConnectionPDO.class.php';
$pdo = dbConnectionPDO::connect();  

	global $pdo;
 
 // creates session variable to show when admin is logged in
function login($pass, $name) {

	
		global $pdo;
        $pass = md5($pass);


	$sql= "SELECT * FROM tbluser WHERE user_password = :pass AND user_name=:name";

	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
 

	if ($row['user_name'] ) {
            $_SESSION['username_C'] = $row['user_name'];
				
		if($row['user_type'] == "admin") {
			$_SESSION['isAdminC']=1;
            $_SESSION['isSUserC']=0;
			echo "Admin logged in: ";
            Header( "Location: usermain.php" );
		}

		if($row['user_type'] == "superuser") {
			$_SESSION['isSUserC']=1;
            $_SESSION['isAdminC']=0;
			echo "User logged in: ";//.$_SESSION['isUserC'];
            Header( "Location: usermain.php" );
		}
}
else
?>

<div style="font-weight: bold; color: red; text-align: center;padding-left: -25px;
  " class="loginerror"> Incorrect Password, Please try again!!!</div>
<?php
}

function logout() {

if(isset($_SESSION['username_C'])){
        		global $pdo;
    $uname = $_SESSION['username_C'];
	$uname = mysqli_real_escape_string($uname);
	$count=$pdo->prepare("DELETE FROM usersonline WHERE username=:uname");
	$count->bindParam(":uname",$uname,PDO::PARAM_STR);
	$count->execute();
    }

	if(isset($_SESSION['isAdminC']) || isset($_SESSION['isSUserC'])){

	$_SESSION['isAdminC']=0;
	$_SESSION['isSUserC']=0;


}	
}

?>


<style type="text/css">
</style>
 
<title> Customers Management System</title>
    <div style="font-weight: bold; text-align: center; font-size: xx-large; ">
    </div>

<?php
if (isset($_POST['submit'])){
if ($_POST['submit'] == "Login") {
	login ($_POST['pass'], $_POST['login']);
	
}}
else {
	logout();
}


?>
</div>

<div class="loginWrapper">
    <form name="login" action="adminLogin.php" method="post" id="login">
    
    <div class="loginPic">
            
            <a href="#" title="" >
            <img src="designimages/logo.png" alt="" style="width:250px;height:250px;" >
            
            </a>
            <div style="font-weight: bold; text-align: center; ">
            <div style="font-size:25px;">Customers Management System</div>
             <div style="font-size:18px;">Login Form</div>
           
            
            </div>
            <div class="loginActions">
                <div><a href="#" title="" class="logback flip" style="left: 0px; opacity: 1;top:110px;" id="flip_href"></a></div>
                <div><a href="#" title="Main" class="logright" style="right: 0px; opacity: 1;top:110px;" ></a></div>
            </div>
        </div>

            
        <input type="text" name="login"  placeholder="Your username" class="loginUsername">
        <input type="password" name="pass" placeholder="Password" class="loginPassword" size="20">
        
        <div class="logControl">
            <input type="submit" name="submit" value="Log Out" class="buttonM_Exit bBlue">  
			<input type="submit" name="submit" value="Login" class="buttonM_login bBlue" >          
        </div>
        
       

    </form>    
    <form name="login" action="#" method="post" id="recover">
    <div class="loginPic">
            <a href="#" title="" class=" flip"  >
            <img src="designimages/logo.png" alt="" style="  padding-right: 9px;">
            </a>
            

            <div style="font-weight: bold; text-align: center; font-size: 35px; ">Customers Management System

            </div>

        </div>
        
        
        
    </form>
    
   
    
</div>


<script class="" src="new_login/jquery.min.js"></script>
<script>
$(function(){
	window.globalVar = 0;
	// Checking for CSS 3D transformation support
	$.support.css3d = supportsCSS3D();

	var formContainer = $('.loginWrapper');
	// Listening for clicks on the ribbon links
	$('.flip').click(function(e){
		//alert('here');
		// Flipping the forms
		
		if(globalVar == 0)
		{
			globalVar = 1; //means flipped to main 
		}
		else
		{
			globalVar = 0; //means flipped to login user
		}
		
		formContainer.toggleClass('flipped');
		
		// If there is no CSS3 3D support, simply
		// hide the login form (exposing the recover one)
		if(!$.support.css3d){
			$('#login').toggle();
		}
		e.preventDefault();
	});
	
	formContainer.find('form').submit(function(e){
		// Preventing form submissions. If you implement
		// a backend, you might want to remove this code
		//e.preventDefault();
	});
	
	
	// A helper function that checks for the 
	// support of the 3D CSS3 transformations.
	function supportsCSS3D() {
		var props = [
			'perspectiveProperty', 'WebkitPerspective', 'MozPerspective'
		], testDom = document.createElement('a');
		  
		for(var i=0; i<props.length; i++){
			if(props[i] in testDom.style){
				return true;
			}
		}
		
		return false;
	}

	$('.checker').click(function(e){
		$(this).children('span').toggleClass('checked');
	});
	
});



</script>
<br class="clear" />
</div>

<div class="footer">
    
</div>
	<div class="header2" style="    background-color: #ffffff;">
    <div style="font-weight: bold; text-align: center; font-size: x-large; padding-top: 3%; padding-bottom:2%;">
   
	</div>
  </div>
  <div class="footer">
    
</div>
    
    </div>
</body>
</html>