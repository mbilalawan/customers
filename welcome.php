<style type="text/css" media="print">
.dontprint
{ display: none; }
</style>
<div class="welcome dontprint">
     <p style="font-size: small; text-align: center;"> 
       
     <span style="color: aqua; font-size: large; text-decoration: none;">Welcome
            <?=$_SESSION['username_C'];?> </span> |

<?php
include "db_config.php";
include_once ("classes/usersOnline.class.php"); 
//$visitors_online = new usersOnline($_SESSION['username_C']); 


?>  
        <A href="adminLogin.php" style="color: white; font-size: large; text-decoration: none;">Exit</A>  
     </p>
 </div>