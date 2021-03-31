<?php

include "../db_config.php";

	$q=$_GET['q'];
	$my_data=mysql_real_escape_string($q);
	$sql="SELECT subdept FROM departments WHERE subdept LIKE '%$my_data%' ORDER BY subdept";
	$result = mysql_query($sql) or die(mysql_error());
	
	if($result)
	{
		while($row=mysql_fetch_array($result))
		{
			echo $row['subdept']."\n";
		}
	}
?>