<?php
include "db_config.php";
ini_set('display_errors',1);
error_reporting(1);

class uploadFile {
#################  Get file type binary method  ###########
function getImgType($filename) {
    $handle = @fopen($filename, 'r');
	echo $filename;
	//exit();
    if (!$handle)
	{
		echo $filename;
        throw new Exception('File Open Error');
	}
	
    $types = array('jpeg' => "\xFF\xD8\xFF",'jpg' => "\xFF\xD9", 'gif' => 'GIF', 'png' => "\x89\x50\x4e\x47\x0d\x0a", 'pdf' => "%PDF");
    $bytes = fgets($handle, 8);
    $found = 'other';

    //echo '<br> type header='.$bytes;

    foreach ($types as $type => $header) {
	
        if (strpos($bytes, $header) === 0) {
            $found = $type;
            break;
        }
    }
    fclose($handle);
    return $found;
}
#############################################################

###################  Get extension type method  #############
//This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
#############################################################

function full_url($s, $use_forwarded_host=false)
{
    return $this->url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
}



function getIP() {
	/*
	This function will try to find out if user is coming behind proxy server. Why is this important?
	If you have high traffic web site, it might happen that you receive lot of traffic
	from the same proxy server (like AOL). In that case, the script would count them all as 1 user.
	This function tryes to get real IP address.
	Note that getenv() function doesn't work when PHP is running as ISAPI module
	*/
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

/////////////  Start Upload File  ////////////
function uploadFileSingle($fk_id,$is_edit=NULL)
{
  //echo 'file55';exit;
		$user_ip =  $this->getIP();
		
		//$user_name   = $_SESSION['username'];
		//$full_name   = $_SESSION['full_name'];

		//define a maxim size for the uploaded images in Kb
 		define ("MAX_SIZE","8000"); 
		#########  Binary checks for file type ###############
			$file_type = $this->getImgType($_FILES['uploaded_file']['tmp_name']);
			
			if($file_type == 'other')
			  {
			  	
				echo '<div align="center" style="color:#FF0000">Can not upload this type of file!</div>';
				
				 //$referer = parse_url($_SERVER['HTTP_REFERER']);
   				 //header('location:'. $referer);
				exit;
			  }
		######################################################
		
		################# Other type check   #################
		//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['uploaded_file']['name']);
 	//get the extension of the file in a lower case format
  		$extension = $this->getExtension($filename);
 	    $extension = strtolower($extension);
                
		$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf");
		$temp = explode(".", $_FILES["uploaded_file"]["name"]);
		$extensions = strtolower(end($temp));

		######################################################
		  if (( ($_FILES["uploaded_file"]["type"] == "image/gif")
                || ($_FILES["uploaded_file"]["type"] == "image/jpeg")
                || ($_FILES["uploaded_file"]["type"] == "image/jpg")
                || ($_FILES["uploaded_file"]["type"] == "image/pjpeg")
                || ($_FILES["uploaded_file"]["type"] == "image/x-png")
                || ($_FILES["uploaded_file"]["type"] == "image/png")
                || ($_FILES["uploaded_file"]["type"] == "application/pdf"))
                && in_array($extensions, $allowedExts))
                  {
				  
				  
				  ################ size check  ###################
				    $size=filesize($_FILES['uploaded_file']['tmp_name']);
					echo 'size='.$size;
					echo '<br> size allowed = '.MAX_SIZE*1024;
					if ($size > MAX_SIZE*10245)
                        {
                                echo '<div align="center" style="color:red">You have exceeded the size limit!</div>';
                                $errors=1;
								exit;
                        }
				  ###################################################
  //upload file


###########################  Image Resizing  ##########################
// Create an Image from it so we can do the resize
$flag_img=0;
                  if($_FILES["uploaded_file"]["type"] == "image/png")
				  {  
                    	$src1 = imagecreatefrompng($_FILES['uploaded_file']['tmp_name']);
                   		$flag_img=1;
                  }
                  else if (($_FILES["uploaded_file"]["type"] == "image/jpg")||($_FILES["uploaded_file"]["type"] == "image/jpeg"))
                  {
                    	$src1 = imagecreatefromjpeg($_FILES['uploaded_file']['tmp_name']);
                    	$flag_img=1;
                  }
                  else if ($_FILES["uploaded_file"]["type"] == "image/gif")
                  {
                    	$src1 = imagecreatefromgif($_FILES['uploaded_file']['tmp_name']);
                    	$flag_img=1;
                  }

if($flag_img==1)
{				  
		 // Capture the original size of the uploaded image
		list($width1,$height1)=getimagesize($_FILES['uploaded_file']['tmp_name']);
		if(($width1 > 700)||($width1 >= '1000')||($width1 >= 1000))
		{
				$newwidth=700;
				$newheight=($height1/$width1)*$newwidth;
				$tmp=imagecreatetruecolor($newwidth,$newheight);
				imagecopyresampled($tmp,$src1,0,0,0,0,$newwidth,$newheight,$width1,$height1);
				imagejpeg($tmp,$_FILES['uploaded_file']['tmp_name'],100);
				imagedestroy($tmp); // NOTE: PHP will clean up the temp file it created when the request
		}
}
#######################################################################
// Gather all required data
        
        $mime = mysqli_real_escape_string($_FILES['uploaded_file']['type']);
		$content = mysqli_real_escape_string(file_get_contents($_FILES['uploaded_file']['tmp_name']));
        //$content = mysql_real_escape_string(file_get_contents($_FILES['uploaded_file']['tmp_name']));      
        $newname=time().'-'.$filename;
				
	//primary id of main table record
	$p_id =$fk_id;

	if($is_edit == 1) //edit document so delete previous document
	{
		$query_upd="UPDATE tbl_upl SET is_del='1',date_updated=NOW() WHERE fk_id = '$p_id'";
		mysqli_query($query_upd) or die (mysql_query());
	}
						    $insert_archive_query="INSERT INTO tbl_upl SET name='$newname',type='$mime',size='$size',content = '$content', fk_id='$p_id', date_created=NOW(),user_ip='$user_ip'";
						
						    mysqli_query('SET GLOBAL max_allowed_packet = ' . 500 * 1024 * 1024);
							mysqli_query($insert_archive_query) or die (mysql_query());
							
							echo '<div align="center" style="color:green">Uploaded Successfully!</div>';		

	}
	else
	  {
		  echo '<div align="center" style="color:red">Invalid file</div>';
		  $errors=1;
		  //exit;
	  }
		
		/////////////////////////////////////////////

}
////////////////  End Upload File  ////////////////////

/////////////  Start Upload Multiple File  ////////////
 function uploadFileMultiples($fk_id,$is_edit=NULL)
{
  //echo 'file';
		$user_ip =  $this->getIP();
		//echo 'file_type2='.$user_ip;exit;
		//$user_name   = $_SESSION['username'];
		//$full_name   = $_SESSION['full_name'];

		//define a maxim size for the uploaded images in Kb
 		define ("MAX_SIZE","8000"); 
		$i=0;
		foreach ($_FILES['uploaded_file']['name'] as $f)
			  {
				 
		#########  Binary checks for file type ###############
			$file_type = $this->getImgType($_FILES['uploaded_file']['tmp_name'][$i]);
			 //echo 'file_type2='.$file_type;exit;
			if($file_type == 'other')
			  {
			  	
				echo '<div align="center" style="color:#FF0000">Can not upload this type of file!</div>';
				
				 //$referer = parse_url($_SERVER['HTTP_REFERER']);
   				 //header('location:'. $referer);
				exit;
			  }
		######################################################
		
		################# Other type check   #################
		//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['uploaded_file']['name'][$i]);
 	//get the extension of the file in a lower case format
  		$extension = $this->getExtension($filename);
 	    $extension = strtolower($extension);
                
		$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf");
		$temp = explode(".", $_FILES["uploaded_file"]["name"][$i]);
		$extensions = strtolower(end($temp));

		######################################################
		  if (( ($_FILES["uploaded_file"]["type"][$i] == "image/gif")
                || ($_FILES["uploaded_file"]["type"][$i] == "image/jpeg")
                || ($_FILES["uploaded_file"]["type"][$i] == "image/jpg")
                || ($_FILES["uploaded_file"]["type"][$i] == "image/pjpeg")
                || ($_FILES["uploaded_file"]["type"][$i] == "image/x-png")
                || ($_FILES["uploaded_file"]["type"][$i] == "image/png")
                || ($_FILES["uploaded_file"]["type"][$i] == "application/pdf"))
                && in_array($extensions, $allowedExts))
                  {
				  
				  
				  ################ size check  ###################
				    $size=filesize($_FILES['uploaded_file']['tmp_name'][$i]);
					echo 'size='.$size;
					echo '<br> size allowed = '.MAX_SIZE*1024;
					if ($size > MAX_SIZE*10245)
                        {
                                echo '<div align="center" style="color:red">You have exceeded the size limit!</div>';
                                $errors=1;
								exit;
                        }
				  ###################################################
  //upload file


###########################  Image Resizing  ##########################
// Create an Image from it so we can do the resize
$flag_img=0;
                  if($_FILES["uploaded_file"]["type"][$i] == "image/png")
				  {  
                    	$src1 = imagecreatefrompng($_FILES['uploaded_file']['tmp_name'][$i]);
                   		$flag_img=1;
                  }
                  else if (($_FILES["uploaded_file"]["type"][$i] == "image/jpg")||($_FILES["uploaded_file"]["type"][$i] == "image/jpeg"))
                  {
                    	$src1 = imagecreatefromjpeg($_FILES['uploaded_file']['tmp_name'][$i]);
                    	$flag_img=1;
                  }
                  else if ($_FILES["uploaded_file"]["type"][$i] == "image/gif")
                  {
                    	$src1 = imagecreatefromgif($_FILES['uploaded_file']['tmp_name'][$i]);
                    	$flag_img=1;
                  }

if($flag_img==1)
{				  
		 // Capture the original size of the uploaded image
		list($width1,$height1)=getimagesize($_FILES['uploaded_file']['tmp_name'][$i]);
		if(($width1 > 700)||($width1 >= '1000')||($width1 >= 1000))
		{
				$newwidth=700;
				$newheight=($height1/$width1)*$newwidth;
				$tmp=imagecreatetruecolor($newwidth,$newheight);
				imagecopyresampled($tmp,$src1,0,0,0,0,$newwidth,$newheight,$width1,$height1);
				imagejpeg($tmp,$_FILES['uploaded_file']['tmp_name'],100);
				imagedestroy($tmp); // NOTE: PHP will clean up the temp file it created when the request
		}
}
#######################################################################
// Gather all required data
        
        $mime = mysql_real_escape_string($_FILES['uploaded_file']['type'][$i]);
		$content = mysql_real_escape_string(file_get_contents($_FILES['uploaded_file']['tmp_name'][$i]));
        //$content = mysql_real_escape_string(file_get_contents($_FILES['uploaded_file']['tmp_name']));      
        $newname=time().'-'.$filename;
				
	//primary id of main table record
	$p_id =$fk_id;

	if($is_edit == 1) //edit document so delete previous document
	{
		$query_upd="UPDATE tbl_upl SET is_del='1',date_updated=NOW() WHERE fk_id = '$p_id'";
		mysql_query($query_upd) or die (mysql_query());
	}
						    $insert_archive_query="INSERT INTO tbl_upl SET name='$newname',type='$mime',size='$size',content = '$content', fk_id='$p_id', date_created=NOW(),user_ip='$user_ip'";
						
						    mysql_query('SET GLOBAL max_allowed_packet = ' . 500 * 1024 * 1024);
							mysql_query($insert_archive_query) or die (mysql_query());
							
							echo '<div align="center" style="color:green">Uploaded Successfully!</div>';
							//exit;
							
							

	}
	else
	  {
		  echo '<div align="center" style="color:red">Invalid file</div>';
		  $errors=1;
		  //exit;
	  }
		
		/////////////////////////////////////////////
		
		$i++;
	} // end foreach
}
////////////////  End Upload Multiple File  ////////////////////

/////////////  Start Upload Multiple File in folder ////////////
//function uploadFileMultiples_folder($fk_id,$reply,$is_edit=NULL)
function uploadFileMultiples_folder($fk_id,$is_edit=NULL)
{
  //echo 'file';
		$user_ip =  $this->getIP();
		//echo 'file_type2='.$user_ip;exit;
		//$user_name   = $_SESSION['username'];
		//$full_name   = $_SESSION['full_name'];

		//define a maxim size for the uploaded images in Kb
 		define ("MAX_SIZE","8000"); 
		$i=0;
		foreach ($_FILES['uploaded_file']['name'] as $f)
			  {
				 
		#########  Binary checks for file type ###############
			$file_type = $this->getImgType($_FILES['uploaded_file']['tmp_name'][$i]);
			 //echo 'file_type2='.$file_type;exit;
			if($file_type == 'other')
			  {
			  	
				echo '<div align="center" style="color:#FF0000">Can not upload this type of file!</div>';
				
				 //$referer = parse_url($_SERVER['HTTP_REFERER']);
   				 //header('location:'. $referer);
				exit;
			  }
		######################################################
		
		################# Other type check   #################
		//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['uploaded_file']['name'][$i]);
		$file_tmp_name = $_FILES['uploaded_file']['tmp_name'][$i];
		
 	//get the extension of the file in a lower case format
  		$extension = $this->getExtension($filename);
 	    $extension = strtolower($extension);
                
		$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf");
		$temp = explode(".", $_FILES["uploaded_file"]["name"][$i]);
		$extensions = strtolower(end($temp));

		$file_type = $_FILES["uploaded_file"]["type"][$i];
		
		######################################################
		  if (( ($_FILES["uploaded_file"]["type"][$i] == "image/gif")
                || ($_FILES["uploaded_file"]["type"][$i] == "image/jpeg")
                || ($_FILES["uploaded_file"]["type"][$i] == "image/jpg")
                || ($_FILES["uploaded_file"]["type"][$i] == "image/pjpeg")
                || ($_FILES["uploaded_file"]["type"][$i] == "image/x-png")
                || ($_FILES["uploaded_file"]["type"][$i] == "image/png")
                || ($_FILES["uploaded_file"]["type"][$i] == "application/pdf"))
                && in_array($extensions, $allowedExts))
                  {
				  
				  ######### start uploading file #################
						 
							 // $categoryName = get_record_for('gallery_category', 'category_name', array('category_id' => $_POST['category_id']));
							  
							 // $new_file_name = time().'_'.$filename;
							 $new_file_name = time().$i.'.'.$extension;
							 
							 // $caption = addslashes($_POST['caption']);
							 // $caption = '';
							  //$sql = 'INSERT INTO gallery_images (category_id, image_file, caption) 
							//		  VALUES ('.$_POST['category_id'].', "'.$new_file_name.'", "'.$caption.'")';
			  
							//$foldername =
								if (!file_exists('uploads/'.date("Y").'/'.date("M").'/'.date("d").'/')) {
										mkdir('uploads/'.date("Y").'/'.date("M").'/'.date("d").'/', 0755, true);
								}
								
								$dirpath = 'uploads/'.date("Y").'/'.date("M").'/'.date("d").'/';
								$full_path_file_name = '';
								$full_path_file_name = $dirpath.$new_file_name;
								//echo $full_path_file_name;
								
							//  if(move_uploaded_file($file['tmp_name'],'images/'.$new_file_name))
							  if(move_uploaded_file($file_tmp_name,$dirpath.$new_file_name))
							  {
						//		  if(mysql_query($sql))
						//		  {
							//echo "here";
							//print_r($dbh);
									  //unset($_POST);
									  $sMsg = '<span style="color:#090">Added Sucessfully!</span>';
									  
									  
									  //add image insert query
									  // $insert_image_query="INSERT INTO tbl_images SET img_name='$full_path_file_name',fk_id_tbl_visitors='$fk_id', datetime_created=NOW(),user_ip='$user_ip',fk_visitor_scan_id='$fk_visitor_scan_id'";
									  
									  $insert_image_query="INSERT INTO tbl_upl SET name='$full_path_file_name',type='$file_type',fk_id='$fk_id', date_created=NOW(),user_ip='$user_ip'";
									  	//echo  $insert_image_query;
						    			mysqli_query($dbh,'SET GLOBAL max_allowed_packet = ' . 500 * 1024 * 1024);
										mysqli_query($dbh,$insert_image_query) or die (mysqli_query());

										echo '<div align="center" style="color:green">Uploaded Successfully!</div>';
																	//echo "here";
							//exit;
							
							
						//		  }
						//		  else
						//		  {
						//					if(file_exists('../galleryimages/'.$new_file_name))
						//					{
						//						unlink('../galleryimages/'.$new_file_name);
						//					}
						//				  $sMsg = '<span style="color:#F00">Error on Inserting Record</span>';
						//		  }
							  }
						  
				  #####################################################
				  
		
	//primary id of main table record
	$p_id =$fk_id;

	if($is_edit == 1) //edit document so delete previous document
	{/*
		$query_upd="UPDATE tbl_upl SET is_del='1',date_updated=NOW() WHERE fk_id = '$p_id'";
		mysql_query($query_upd) or die (mysql_query());*/
	}
	
	
							
							echo '<div align="center" style="color:green">Uploaded Successfully!</div>';
							//exit;
							
							

	}
	else
	  {
		  echo '<div align="center" style="color:red">Invalid file</div>';
		  $errors=1;
		  //exit;
	  }
		
		/////////////////////////////////////////////
		
		$i++;
	} // end foreach
}
////////////////  End Upload Multiple File in folder  ////////////////////

	public static function deleteFile($fk_id)
	{			
			$query_del="UPDATE tbl_upl SET is_del='1',date_updated=NOW() WHERE fk_id = '$fk_id'";
			mysql_query($query_del) or die (mysql_query());
			echo '<div align="center" style="color:green">Deleted Successfully!</div>';			
	}
}



	
	


?>