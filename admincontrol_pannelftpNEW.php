<?php
session_start();

//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(0);
@ini_set('display_errors', 0);
if(($_SESSION['isAdminC']==1) || ($_SESSION['isSUserC']==1) || ($_SESSION['isUserC']==1) || ($_SESSION['isSecurityUser']==1))
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
  Add Customers
</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

  <link rel="stylesheet" href="jquery-ui.css" />
<!--  <script src="jquery-1.9.1.js"></script>-->
  <script src="jquery-1.7.1.js"></script>
  <script src="jquery-ui.js"></script>

  <script src="jquery.ui.datepicker-ar.js"></script> 


  <script>
  $(document).ready(function(){ 
    $("input[name$='group1']").click(function() {
        var test = $(this).val();
        $("div.desc").hide();
        $("div.desc1").hide();
        $("#"+test).show();
    }); 
});
  </script>

  <!--//Start autocomplete --> 
<link rel="stylesheet" type="text/css" href="autocomplete/jquery.autocomplete.css" />
<script type="text/javascript" src="autocomplete/jquery.autocomplete.js"></script>
<script>
$(this.target).find('input').autocomplete();
$(document).ready(function(){

 $("#from_department").autocomplete("autocomplete/autocomplete.php", {
		selectFirst: true
	});	
	
$("#to_department").autocomplete("autocomplete/autocomplete.php", {
		selectFirst: true
	});	
	

});
</script>

<!--//End autocomplete --> 




<style type="text/css">
   .desc { display: block; }
   .desc1 { display: none; }
</style>
<script>
  $(document).ready(function(){ 
    $("#select").change(function() {
        var sel = $(this).val();
        if((sel == 11) || (sel == 12)){
            $("div.checkyd").show();
            if(sel == 11){
                $("div.wcolor").show();
                $("div.dcolor").hide();}
            else{
                $("div.dcolor").show();
                $("div.wcolor").hide();}
        }
        else{ 
            $("div.checkyd").hide();
            $("div.wcolor").hide();
            $("div.dcolor").hide();
        }
        
        //$("#"+sel).show();
    }); 
});
</script>
<style type="text/css">
   .checkyd { display: none; }
   .wcolor { display: none; }
   .dcolor { display: none; }
</style>
<style type="text/css">

a:link { color: #CC0000;}
a:visited { color: #CC0000;}
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}

</style>
 

<SCRIPT LANGUAGE=JAVASCRIPT>
function verify(){
if (document.getElementById('FirstName').value=="")
    {
        alert('Please enter First Name.');
		document.getElementById('FirstName').focus();
		return false;
    }
   else {
        return true;
    }
	
if (document.getElementById('LastName').value=="")
    {
        alert('Please enter Last Name.');
		document.getElementById('LastName').focus();
		return false;
    }
   else {
        return true;
    }
}
</SCRIPT>




<!--For color picker-->
<script type="text/javascript" src="colorpicker/js/jscolor.js"></script>

</head>

<body>


<div class="container">
    <?php include 'welcome.php'; ?>
 <?php include 'header.php'; ?>
 
  <div class="contentnew">

<?php 


 include 'header_1.php'; 

include "db_config.php";

 ?>

   <form id="myForm" method="post" enctype="multipart/form-data" action="kitab_redirect.php">

    <p class="directions" align="center" style="color:green">
      <legend><strong> <?php
 			echo $_SESSION['query_message'];
			$_SESSION['query_message']='';
 ?></strong></legend>
    </p>
    
    <table width="60%"  border="1" cellspacing="0" cellpadding="4" align="center" >   

	<tr valign="top" >
	  <td colspan="4" class="body_textBold"  style="text-align: center;background-color:#CCC;color:#000000"><b>Add Customer</b></td>
	  </tr>
	<tr valign="top">
                    <td width="11%" class="body_textBold"><div align="left" id="d1"><b>* First Name</b></div></td>
		  <td width="38%" class="body_text"> 
          <div id="1" class="desc" >
				 <input label='' name="FirstName" id="FirstName" type="text" style="text-align: left;" tabindex="1" value="<?=$row['kt_talab_date']?>" style="width: 99%;"> 
				</div>                </td>
				
          <td width="14%" class="body_text"><div align="left" id="d1" style="font-size:16px"><b>* Last Name</b></div></td>
          <td width="39%" class="body_text">
          <input name="LastName" type="text" id="LastName" tabindex="2" style="text-align: left;" onfocus="this.value=''" style="width: 99%;">          </td>
	</tr>
	<tr valign="top">
	  <td class="body_textBold"> <div align="left" id="d1"><b> Location</b></div></td>
	  <td class="body_text">          <select name="location" id="location"   style="width: 318px;height: 37px;" tabindex="4">
              <option value="London" <?php if($location==='London') echo 'selected="selected"';?> >London</option>
              <option value="New York" <?php if($location==='New York') echo 'selected="selected"';?>>New York</option>
              <option value="Paris" <?php if($location==='Paris') echo 'selected="selected"';?>>Paris</option>
         </select> </textarea></td>
	  <td class="body_text"><div align="left" id="a"><b>Picture</b></div></td>
          <td colspan="3" class="body_text">
          <div align="right" id="a">
         
         
        <input type="file" name="uploaded_file[]" multiple="true" tabindex="10" style="width: 99%;" />
         
                             <br>
		  </div
          ></td>
	  </tr>	

      </tr>
	 
	  <tr valign="top">
        <td colspan="4" align="center" class="body_textBold"><input name="submit" type="submit" id="submit" tabindex="11" value="Add " onClick="return verify()"></td>
        </tr>
    </table>
    <!--</fieldset>--></td>
	</tr>
	<TR>
    <TD align=middle>
      <P align="center"><SPAN class= noprint> </SPAN></P>
      </TD></TR>

</table>

<p>
  <map name="home">
    <area shape="rect" coords="14,19,123,69" href="../index.htm">
  </map>
</p>


<input type="hidden" name="task" value="addkitab"  />
</form>

</div>
<?php include 'footer.php'; ?>

  <!-- end .container --></div>
</BODY>

</HTML>
<?php 
}
else {
Header( "Location: adminLogin.php" ); //echo "Invalid User Name or Password";
}
?>