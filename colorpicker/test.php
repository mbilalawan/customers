<!--For color picker-->
<script type="text/javascript" src="js/jscolor.js"></script>

<input class="color {hash:true}" value="<?php if(stripslashes($content_details_row['statements_color'])=='') echo "#FFFFFF";else echo stripslashes($content_details_row['statements_color']);?>" name="statements_color">