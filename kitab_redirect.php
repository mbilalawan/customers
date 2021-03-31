<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Customers Management System</title>
<!--<link href="style.css" rel="stylesheet" type="text/css" />-->
<link rel="stylesheet" href="print.css" type="text/css" media="print" />
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</head> 

<!--<body onload=javascript:print();>-->
<!--<body onload="window.print();" onfocus="window.back();">-->
<body>
<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ERROR);
ini_set('display_errors', 1);

include "db_config.php";

################## for encryption  ################
include_once ("functions.php"); 
###################################################
include 'dbConnectionPDO.class.php';
$pdo = dbConnectionPDO::connect();  
		global $pdo;
		
$task = $_REQUEST['task'];

//define a maxim size for the uploaded images in Kb
 define ("MAX_SIZE","2000"); 
 
function get_client_ip() {
            $ipaddress = '';
            if ($_SERVER['HTTP_CLIENT_IP'])
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if($_SERVER['HTTP_X_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if($_SERVER['HTTP_X_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if($_SERVER['HTTP_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if($_SERVER['HTTP_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if($_SERVER['REMOTE_ADDR'])
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';

            return $ipaddress; 
        }
		
//This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }		

$myIP = get_client_ip();
$created_by_user=$_SESSION['username_C'];

if($task=='addkitab')
{

	$kt_number = $_POST['kt_number'];
	$kt_talab_date = $_POST['kt_talab_date'];
	

	$FirstName = $_POST['FirstName'];	
	$LastName = $_POST['LastName'];
	//$location = $_POST['location'];

	$insert_customer_query="INSERT INTO tblcustomers SET
												firstName=:FirstName,
												lastName=:LastName";
												//location_id=:$location";
										//echo $location;
										$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $pdo->prepare($insert_customer_query);
				$stmt->bindParam(':FirstName', $FirstName, PDO::PARAM_STR);
				$stmt->bindParam(':LastName', $LastName, PDO::PARAM_STR);
				//$stmt->bindParam(':location', $location, PDO::PARAM_STR);
												//print_r($pdo->errorInfo());
				$stmt->execute();

				$row = $stmt->fetch(PDO::FETCH_ASSOC);

	
		$inserted_id =	$pdo->lastInsertId();
	
	//echo $inserted_id;
	//exit;



	################ start upload image to database  ############################
			//reads the name of the file the user submitted for uploading
 			$image=$_FILES['uploaded_file']['name'];
			//if it is not empty
			//print_r($image);
			if ($image && $image[0]!='')
			{
				// upload image				
				include_once ("uploadFile.class.php"); 
				$obj = new uploadFile();
				//$file_upload_ob = $obj->uploadFileMultiples($inserted_id); // to upload files to db
				$file_upload_ob = $obj->uploadFileMultiples_folder($inserted_id);  // to upload files to directory
			}
		############### end image upload to database ##########################

 	$_SESSION['query_message']='Added Successfully!';
 	
	if($_SESSION['isSecurityUser']==1)
	{
		Header( "Location: security.php" ); 
	}
	else
		Header( "Location: admincontrol_pannelftpNEW.php" );
	
	exit;
}


////////////////// start add image  //////////
if($task=='addimage')
{	
	$kt_id = $_POST['kt_id'];
	$reply = $_POST['reply'];
	
	$kt_created_by_user=$_SESSION['username_C'];
		
	################ start upload image to database  ############################
if 	($reply	==1)
{
				################ start upload reply image to database  ############################
			//reads the name of the file the user submitted for uploading
 			$image2=$_FILES['uploaded_file']['name'];
			//if it is not empty
			if ($image2)
			{
				// upload image
				
				include_once ("uploadFile.class.php"); 
				$obj2 = new uploadFile();
				//echo "here";
				//exit();
				$file_upload_ob2 = $obj2->uploadFileMultiples_folder2($kt_id);  // to upload files to directory
			}
		############### end image upload to database ##########################
}
	
 	$_SESSION['query_message']='Added Successfully!';
 	Header( "Location: reportd.php" ); //echo "Invalid User Name or Password";
	
	exit;
}
///////////////// end add image    //////////



#####################
?>
</body>
</html>