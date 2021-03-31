<?php 
session_start();
error_reporting(0);
ini_set("display_errors",0);


if(($_SESSION['isAdminC']==1) || ($_SESSION['isSUserC']==1) || ($_SESSION['isVisitorC']==1) || ($_SESSION['isPVisitorC']==1) || ($_SESSION['isUserC']==1) || ($_SESSION['isDailyC']==1))
{
    date_default_timezone_set('Asia/Qatar');
include "db_config.php"; 
include "functions.php";
include 'dbConnectionPDO.class.php';
$pdo = dbConnectionPDO::connect();  
################# for database file handling ##################
include_once ("uploadFile.class.php"); 
###################################################

if(isset($_POST['clear']))
{
	//echo 'here';
	unset($_POST);
}
        
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="900" />
<title>Customers Management System</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="print.css" type="text/css" media="print" />
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link rel="stylesheet" href="jquery-ui.css" />
<script src="jquery-1.9.1.js"></script>
<script src="jquery-ui.js"></script>
<script src="jquery.ui.datepicker-ar.js"></script>



<style type="text/css">
     .blink {
        animation: blinker 0.6s linear infinite;
        color: red;
        font-size: 16px;
        font-weight: bold;
        font-family: sans-serif;
		padding: 0 1px;
      }
      @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
      .blink-one {
        animation: blinker-one 1s linear infinite;
      }
      @keyframes blinker-one {
        0% {
          opacity: 0;
        }
      }
      .blink-two {
        animation: blinker-two 1.4s linear infinite;
      }
      @keyframes blinker-two {
        100% {
          opacity: 0;
        }
      }






td {
  word-wrap: break-word;
}
</style>
 

<title>Edit Product</title>


<script type="text/javascript">
function getValue(selectObject, p_id) {
if( selectObject.selectedIndex>-1)
	{//alert("List " + selectObject.name + ": " + selectObject.options[selectObject.selectedIndex].value + " " + selectObject.options[selectObject.selectedIndex].text )
	if(selectObject.options[selectObject.selectedIndex].text == "Deny"){
	window.location.href="editgallery.php?p_id="+p_id+"&actype=den";
}
	if(selectObject.options[selectObject.selectedIndex].text == "Edit"){
	window.location.href="editproduct.php?p_id="+p_id;
}
	//alert(selectObject.options[selectObject.selectedIndex].text + ":" + p_id);	
	if(selectObject.options[selectObject.selectedIndex].text == "Delete"){
	msg = "This will Delete the Record and also delte the images if they exist! \n Are you sure you want to do this?"
  	if (confirm(msg))
	window.location.href="editgallery.php?p_id="+p_id+"&actype=del";
}

	}
}

</script>
  <SCRIPT language=JavaScript src="site.js" type=text/javascript></SCRIPT>
 <script language=JavaScript src="imgmag.js"type=text/javascript></script>
 
 
<!-- ########### start script for show hide inner follow up records #############-->
 
     <script>
		$(document).ready(function() {
		  $('.nav-toggle').click(function(){
			//get collapse content selector
			var collapse_content_selector = $(this).attr('href');					
						//alert(collapse_content_selector);			
			//make the collapse content to be shown or hide
			var toggle_switch = $(this);
			$(collapse_content_selector).toggle(function(){
			  if($(this).css('display')=='none'){
                                //change the button label to be 'Show'
				//toggle_switch.html('ملفات');
			  }else{
                                //change the button label to be 'Hide'
				//toggle_switch.html('اخفاء');
			  }
			});
		  });
				
		});	
		$(document).ready(function() {
		  $('.nav-toggle1').click(function(){
			//get collapse content selector
			var collapse_content_selector = $(this).attr('href');					
			//alert(collapse_content_selector);		
			//make the collapse content to be shown or hide
			var toggle_switch = $(this);
			$(collapse_content_selector).toggle(function(){
			  if($(this).css('display')=='none'){
                                //change the button label to be 'Show'
				//toggle_switch.html('ملفات');
			  }else{
                                //change the button label to be 'Hide'
				//toggle_switch.html('اخفاء');
			  }
			});
		  });
				
		});			
		</script>
        
<!--  ########### end script for show hide inner follow up records #############  -->     
<?php include 'livetime.js'; ?>
 </head>
<body onload="startTime()">
<div class="container">
    <?php include 'welcome.php'; ?>
    
    
    <?php include 'headerd.php'; ?>  
    <!-- end .header -->


 <div class="content" style="padding-top:5px !important">

<div align="center">



<form id="myForm" method="post" enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>?f_id=1">

    
       <table border=1 width = '80%' cellpadding='0' cellspacing='0'>
       
  <tr>
    <td colspan="4"  style="text-align: center;background-color:#CCC"><strong>Search Items</strong></td>
    </tr>
  <tr>
    <td colspan="4"  style="text-align: center">
        
    <table width="100%" border="0" style="margin-top: 15px;margin-bottom: 15px;">
  <tr>
  
  <td width="40%" align="center" valign="top"><fieldset style="width:90%">
    <legend align="left">First Name, Last Name, Location</legend>
    <input label='search' name="search_text" type="text" tabindex="1" style="text-align:left" value="<?=$_POST['search_text']?>">
  </fieldset>

  </td>
  
  

    
  
    <td width="37%" align="center" valign="top">
    <fieldset style="width:80%">
    <legend align="left">Sort By</legend>
    
    					<?php
                            		// for kt_status
									$sort_by_selecttion = $_POST['sort_by_selecttion'];
									
                        ?>
                        
    	<select name="sort_by_selecttion" id="sort_by_selecttion"  style="width: 80%;height: 37px;">        	  
              <option value="" <?php if($sort_by_selecttion==='')  echo 'selected="selected"';?> ></option>
              <option value="sort_by_kitab_date_latest_first" <?php if($sort_by_selecttion==='sort_by_kitab_date_latest_first') echo 'selected="selected"';?> >First Name</option>
        	  <option value="sort_by_kitab_date_oldest_first" <?php if($sort_by_selecttion==='sort_by_kitab_date_oldest_first') echo 'selected="selected"';?> >Last Name</option>
         </select>
  </fieldset>    </td>
  </tr>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center">
    
    <input name="submit" type="submit" id="submit" tabindex="13" value="Search" onclick="return verify()" class="buttonM" /> : <input name="clear" type="submit" id="submit" tabindex="13" value="Clear Search Settings" onclick="return verify()" class="buttonM" />    </td>
    </tr>
    </table>


    </td>
  </tr>
  
  
  
 
       </table>


   </form>
</div>
<br />

    <?php


    

	?> 
      <?php //if($fromdate == ""){ ?>
      <div align="center" ><strong style="color:green" > <?php
 			echo $_SESSION['query_message'];
			$_SESSION['query_message']='';
 ?></strong></div>
     <div class='maintabledivdaily' style='width:100%'> 
   
 


     <table border=1 width = '100%' cellpadding='0' cellspacing='0' > 
     
    
     <?php
    $countmaindiv=1;
    
    $totalrowdata = 0;
    $isnextmonth = 0;
       




$rowspan = 0;

		
	########################  where clause  ####################
	$where_clause = '';
	$where_clause_2='';
	$data = array();
	//////////////   get status of kitab from query string  //////////////
	  if($_REQUEST['kt_status']!= '')
	  {
		  $kt_status = $_REQUEST['kt_status'];
	  }
	  else if($_POST['submit'] && $_POST['submit']!='')
	  {
		  $kt_status = $_REQUEST['kt_status'];
	  }
	/////////////////////////////////////////////////////////////////////
	
	$search_text = $_POST['search_text'];
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	
	
	

	


	
	/////////////    For Sorting     /////////////////////////
	
	$order_by_clause = '';
	
	if($sort_by_selecttion == 'First Name')
	{
		//$order_by_clause = " ORDER BY DATE(kt_datetime_created) DESC";	
		$order_by_clause = " ORDER BY (FirstName) DESC";	
	}
	else if($sort_by_selecttion == 'Last Name')
	{
		//$order_by_clause = " ORDER BY DATE(kt_datetime_created) ASC";		
		$order_by_clause = " ORDER BY (LastName) ASC";		
	}

    /////////////////////////////////////////////////////////
	
	
	
	if($_POST['submit'] && $search_text!='')
	{
		
		$where_clause_2 .= " AND ( FirstName LIKE :search_text OR LastName LIKE :search_text )";
		array_push($data[':search_text']="%$search_text%");	

	}
	
	
  
	 
	 
		//$query_withou_paging="SELECT * from tbl_customers where 1=1 $where_clause_2 $order_by_clause"; //without paging
		$query="SELECT * from tblcustomers where 1=1 $where_clause_2 $order_by_clause "; //with paging
		//echo $query;
		global $pdo;		
		//echo $query;
		$pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );
		$stmt = $pdo->prepare($query);
		
		foreach ($data as $key => &$val) 
		{
			$stmt->bindValue($key, $val);
			//echo "Key=" . $key . ", Value=" . $val;
		}

		?>

        <br />
    <tr valign="top"> 
             

	         <td class="galleyBold" bgcolor="#000000" style="color: white; text-align: center;width: 2%;" ><b>Sr.</b></td>
             <td class="galleyBold" bgcolor="#65a6bf" style="text-align: center;width: 7%;"><b>First Name</b></td>
             <td class="galleyBold" bgcolor="#65a6bf" style="text-align: center;width: 10%;"><strong>Last Name</strong></td>
             <td class="galleyBold" bgcolor="#65a6bf" style="text-align: center;width: 18%;"><strong>Location</strong></td>
             <td class="galleyBold" bgcolor="#65a6bf" style="text-align: center;width: 5%"><strong>Picture</strong></td>
 
	 </tr>

<?php
        $stmt->execute();
		$num_rows = $stmt->rowCount();

		
		if($num_rows == 0)
		{
			?>
            <div align="center"> <span style="color:#F00;text-align:center"> <b><?php echo 'No Records Found';//echo 'No Record Found';?></b></span></div>
            <?php
			//echo 'No Record Found';	
		}
		
		
		$idnum = $start_from+1;
		
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	
	$rowdataid = $idnum;

	$FirstName =  $row['firstName'];

	$LastName =$row['lastName'];
    

	
	?>

    <tr>

	         <td class="galleyBold" bgcolor="#FFFFFF" style="text-align: center"><b><?=(nl2br($rowdataid))?></b></td>
             <td class="galleyBold" bgcolor="" style="text-align: center;">
             <?php
			 			echo $FirstName;
			 ?>             </td>
             <td class="galleyBold" bgcolor="#FFFFFF"  >
			 <? //=(nl2br($kt_subject_arabic))?>
              <A target="_blank"  href="output_profile.php?kt_id=<?=$row['kt_id']?>" style="width:18px !important;text-decoration:none">
             <?php
			 
					echo $LastName;
			 ?>  
             </A>                        </td>

             
			 <?php
				$classChange=false;
				$ReplyDate = $row['kt_mawalid'];
				$Date = date('Y-m-d'); #Or Current Date Fixed here
 
				$LastDay = date("Y-m-d", strtotime('+7 days')); 
				
				if($ReplyDate < $LastDay) {
				   $classChange=true;
				}   
			?>
             <td class="galleyBold" bgcolor="#FFFFFF" style="text-align: center;">
             
     <span style="font-size:10px;color:#F00"> <?=$row['kt_created_by_user'];?></span>
   
   <?php
         if(isset($row['kt_datetime_modified']) && $row['kt_datetime_modified']!='' && $row['kt_user_modified']!='')
		 {
		 ?>
    <br />
     <!--<span style="font-size:10px;color:#999">Edit by :</span>-->
    <span style="font-size:10px;color:#F00"> <?=$row['kt_user_modified'];?></span>   
    
    <?php
	}
	?>             </td>
             <!--<td class="galleyBold" bgcolor="" style="text-align: center;"><?=(nl2br($kt_status))?></td>-->
             <td class="galleyBold" bgcolor="#FFFFFF" style="text-align: center;width: 14%;">

</td>
     </tr>
     
     <!--   Start  Inner records for follow up -->

<?php

//error_reporting(E_ALL);
//ini_set("display_errors",1);

		$kt_id_main_record = $row['customer_id'];
		$where_clause_inner = '';
		$where_clause_inner .= " AND (fk_id = '$kt_id_main_record') ";

		$query_inner="SELECT * from tbl_upl where  (fk_id = :kt_id_main_record)  ORDER BY id asc";
		$stmt3 = $pdo->prepare($query_inner);
		$stmt3->bindParam(':kt_id_main_record', $kt_id_main_record, PDO::PARAM_INT);
		$stmt3->execute();
        
		$num_rows = $stmt3->rowCount();
		
		
		
		if($num_rows == 0)
		{
			?>
            <tr  id="<?=$kt_id_main_record?>" style="display:none">
      			<td colspan="11" bgcolor="#FFFFFF" class="galleyBold" style="text-align: center;" >
                	<div align="center" style="color:#FFF;background-color:#F00">لا متابعة وجدت</div>                </td>
            </tr>
            <!--<span style="color:#F00"> <?php //echo 'No Reply Found';?></span>-->
            <?php
			//echo 'No Record Found';	
		}
		else if($num_rows > 0)
		{
?>
    <tr  id="<?=$kt_id_main_record?>" style="display:none">
      <td colspan="11" bgcolor="#FFFFFF" class="galleyBold" style="text-align: center;" >
      <div align="center">
      <table border=1 width = '60%' cellpadding='0' cellspacing='0' >

      
      <tr valign="top">
        <td colspan="4" bgcolor="cornflowerblue" class="galleyBold" style="color: white; text-align: center">Pictures 
        
        <A title="Close" class="nav-toggle"   href="#<?=$row['customer_id']?>" style="text-decoration:none" >
            <img src="designimages/Close-icon.png" width="26px" style="float:left" />
            </A>
        </td>
        
      </tr>
      

          <tr>

	         <td colspan="3" bgcolor="#FFFFFF" class="galleyBold" style="text-align: center"><b><?=(nl2br($rowdataid_inner))?></b>
             
         <?php 
	################## get image from db #############################
	
	while ($imgrow= $stmt3->fetch(PDO::FETCH_ASSOC)) {
	##################################################################
	
	$enc_id = encrypt($imgrow['id'],'securedkey2015*@#');
	
		if (($imgrow['type'] == 'image/jpg')||($imgrow['type'] == 'image/gif')||($imgrow['type'] == 'image/png')||($imgrow['type'] == 'image/jpeg') || ($imgrow['type'] == 'jpg')||($imgrow['type'] == 'gif')||($imgrow['type'] == 'png')||($imgrow['type'] == 'jpeg')) 
		{ 
       		
        ?>
        <!-- for fetching image from db
        	<A target="_blank" href="view_doc.php?id=<?=$enc_id?>&t=<?=time();?>" onmouseover="doTooltip(event,0,'view_doc.php?id=<?=$enc_id?>','<?=$row['kt_subject']?>')" onMouseOut="hideTip()" onClick="hideTip()"><IMG src="view_doc.php?id=<?=$enc_id?>" width="70px" height="70px" /></A> 			  
			-->
            
            <A target="_blank" href="view_doc.php?id=<?=$enc_id?>&t=<?=time();?>" onmouseover="doTooltip(event,0,'<?=$imgrow['name']?>','<?=$row['kt_subject']?>')" onMouseOut="hideTip()" onClick="hideTip()">
        	<IMG src="<?=$imgrow['name']?>" width="70px" height="70px" />			</A>
			
			<?php
			//echo '<img src="showimg.php?id='.$id.'" class="imgread"/>';
			 } 
		else if ($imgrow['type'] == 'application/pdf' || $imgrow['type'] == 'pdf') 
		{ ?> 
        	<A target="_blank" href="view_doc.php?id=<?=$enc_id?>&t<?=time();?>"> <IMG src="images/pdfic.png"></A> 
  <?php } ?>
		
             
  <?php } //end while ?>                    </td>
             <td class="galleyBold" bgcolor="#FFFFFF" style="text-align: center;width:10%">
     
                  <A title="View/Print" target="_blank"  href="output_profile.php?kt_id=<?=$row['kt_id']?>" style="text-decoration:none" >
                  <img src="designimages/print_preview-128.png" width="40px"  />
                  </A>
    
     <br />
    <span style="font-size:16px;color:#999"> <?=$row_inner['created_datetime']?></span> <span style="font-size:10px;color:#F00"> <?=$row_inner['created_by_user'];?></span>    		</td>
     	</tr>
           <?php
		//}  //end while inner
		?>
     </table>
     </div>      </td>
      </tr>      

	  
	  
   <?php
		}  //end else if
		?>

<!-- second toggle div for reply images --> 			 

<?php

//error_reporting(E_ALL);
//ini_set("display_errors",1);

		$kt_id_main_record = $row['kt_id'];
		$where_clause_inner = '';
		$where_clause_inner .= " AND (fk_id = '$kt_id_main_record') ";

		$query_inner="SELECT * from tbl_upl_2 where is_del=0  AND (fk_id = :kt_id_main_record)  ORDER BY id asc";
		$stmt9 = $pdo->prepare($query_inner);
		$stmt9->bindParam(':kt_id_main_record', $kt_id_main_record, PDO::PARAM_INT);
		$stmt9->execute();
        
		$num_rows = $stmt9->rowCount();
		
		
		
		if($num_rows == 0)
		{
			?>
            <tr  id="<?=$kt_id_main_record?>_1" style="display:none">
      			<td colspan="11" bgcolor="#FFFFFF" class="galleyBold" style="text-align: center;" >
                	<div align="center" style="color:#FFF;background-color:#F00">لا متابعة وجدت</div>                </td>
            </tr>
            <!--<span style="color:#F00"> <?php //echo 'No Reply Found';?></span>-->
            <?php
			//echo 'No Record Found';	
		}
		else if($num_rows > 0)
		{
?>
    <tr  id="<?=$kt_id_main_record?>_1" style="display:none">
      <td colspan="11" bgcolor="#FFFFFF" class="galleyBold" style="text-align: center;" >
      <div align="center">
      <table border=1 width = '60%' cellpadding='0' cellspacing='0' >

      
      <tr valign="top">
        <td colspan="4" bgcolor="cornflowerblue" class="galleyBold" style="color: white; text-align: center">الردود 
        
        <A title="Close" class="nav-toggle1" href="#<?=$row['kt_id']?>_1" style="text-decoration:none" >
            <img src="designimages/Close-icon.png" width="26px" style="float:left" />
            </A>
        </td>
        
      </tr>
      

          <tr>

	         <td colspan="3" bgcolor="#FFFFFF" class="galleyBold" style="text-align: center"><b><?=(nl2br($rowdataid_inner))?></b>
             
         <?php 
	################## get image from db #############################
	
	while ($imgrow= $stmt9->fetch(PDO::FETCH_ASSOC)) {
	##################################################################
	
	$enc_id = encrypt($imgrow['id'],'securedkey2015*@#');
	
		if (($imgrow['type'] == 'image/jpg')||($imgrow['type'] == 'image/gif')||($imgrow['type'] == 'image/png')||($imgrow['type'] == 'image/jpeg') || ($imgrow['type'] == 'jpg')||($imgrow['type'] == 'gif')||($imgrow['type'] == 'png')||($imgrow['type'] == 'jpeg')) 
		{ 
       		
        ?>
        <!-- for fetching image from db
        	<A target="_blank" href="view_doc.php?id=<?=$enc_id?>&t=<?=time();?>" onmouseover="doTooltip(event,0,'view_doc.php?id=<?=$enc_id?>','<?=$row['kt_subject']?>')" onMouseOut="hideTip()" onClick="hideTip()"><IMG src="view_doc.php?id=<?=$enc_id?>" width="70px" height="70px" /></A> 			  
			-->
            
            <A target="_blank" href="view_doc_1.php?id=<?=$enc_id?>&t=<?=time();?>" onmouseover="doTooltip(event,0,'<?=$imgrow['name']?>','<?=$row['kt_subject']?>')" onMouseOut="hideTip()" onClick="hideTip()">
        	<IMG src="<?=$imgrow['name']?>" width="70px" height="70px" />			</A>
			
			<?php
			//echo '<img src="showimg.php?id='.$id.'" class="imgread"/>';
			 } 
		else if ($imgrow['type'] == 'application/pdf' || $imgrow['type'] == 'pdf') 
		{ ?> 
        	<A target="_blank" href="view_doc_1.php?id=<?=$enc_id?>&t<?=time();?>"> <IMG src="images/pdfic.png"></A> 
  <?php } ?>
		

             
  <?php } //end while ?>                    </td>
             <td class="galleyBold" bgcolor="#FFFFFF" style="text-align: center;width:10%">
     
                  <A title="View/Print" target="_blank"  href="output_profile.php?kt_id=<?=$row['kt_id']?>" style="text-decoration:none" >
                  <img src="designimages/print_preview-128.png" width="40px"  />
                  </A>

    
     <br />
    <span style="font-size:16px;color:#999"> <?=$row_inner['created_datetime']?></span> <span style="font-size:10px;color:#F00"> <?=$row_inner['created_by_user'];?></span>    		</td>
     	</tr>
           <?php
		//}  //end while inner
		?>
     </table>
     </div>      </td>
      </tr>      

	  
	  
   <?php
		}  //end else if
		?>   

     <tr >
      <td colspan="11" bgcolor="#FFFFFF" class="galleyBold" style="text-align: center;" >
      <div align="center">

     </div>      </td>
      </tr>
      

      
    <?php

$idnum++;	
	
}
?>

<tr valign="top">
    <td colspan="15" style="text-align:center">
    
        <?php 
 ########### for paging ##################   

$sql = "SELECT kt_id from tbl_kitab where 1=1 $where_clause"; 


				
		$pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );
		$stmt5 = $pdo->prepare($sql);
		foreach ($data as $key => &$val) 
		{
			$stmt5->bindValue($key, $val);
			//echo "Key=" . $key . ", Value=" . $val;
		}
		$stmt5->execute();
		$total_records = $stmt5->rowCount();
		$total_pages = ceil($total_records / $num_rec_per_page); 

echo "<a href='reportd.php?f_id=".$f_id."&page=1'>".'|<'."</a> "; // Goto 1st page  

for ($i=1; $i<=$total_pages; $i++) { 
     $style='';
    if($_GET["page"]==$i)
    {
        $style="style='text-decoration:none;'";
    
    }
            echo "<a href='reportd.php?f_id=".$f_id."&page=".$i."&idnum=".$idnum."' ".$style.">".$i."</a> "; 
}; 
echo "<a href='reportd.php?f_id=".$f_id."&idnum=".$idnum."&page=$total_pages'>".'>|'."</a> "; // Goto last page
########### end paging ##################
?>   

 </td>
  </tr>
        </table>


</div>
    
   

  

  
  
  <div style="padding-top:0px">&nbsp;</div>
        
</div>

  <?php //include "header_1.php"; ?>

  <div class="page">
<?php 
//echo "Page 1";
?>
</div>
<div class="page">
<?php
//echo "Page 2";
?>
</div>


<?php include 'footer.php'; ?>

</div>
</body>

</html>
<?php }
else {
Header( "Location: adminLogin.php" ); //echo "Invalid User Name or Password";
}
?>