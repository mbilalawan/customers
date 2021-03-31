<?php
function decrypt($string, $key) {
$result = '';
$string = base64_decode($string);
for($i=0; $i<strlen($string); $i++) {
$char = substr($string, $i, 1);
$keychar = substr($key, ($i % strlen($key))-1, 1);
$char = chr(ord($char)-ord($keychar));
$result.=$char;
}
return $result;
}

function encrypt($string, $key) {
$result = '';
for($i=0; $i<strlen($string); $i++) {
$char = substr($string, $i, 1);
$keychar = substr($key, ($i % strlen($key))-1, 1);
$char = chr(ord($char)+ord($keychar));
$result.=$char;
}
return base64_encode($result);
}

// make bold or highlight
function makeBold($string,$text_color,$highlight_color) {
    
    $quote = '%%'; // to highlight text
    $count = substr_count($string, $quote);
	
    for ($i = 0; $i <= $count/2; $i++) { 
        $string = preg_replace("/$quote/", "<span style='background-color: $highlight_color';>", $string, 1);
        $string = preg_replace("/$quote/", '</span>', $string, 1);
    }
    $quoteg = '##'; // for text color
    $countg = substr_count($string, $quoteg);
    for ($i = 0; $i <= $countg/2; $i++) {
        $string = preg_replace("/$quoteg/", "<span style='color: $text_color;'>", $string, 1);
        $string = preg_replace("/$quoteg/", '</span>', $string, 1);
    } // GREEN END
    
    return $string;
}

// to remove %% and ##
function makeUNBold1($string) {
    $quote = '%%';
	$count = substr_count($string, $quote);
    /*for ($i = 0; $i <= $count/2; $i++) {
        $string = preg_replace("/$quote/", '', $string, 1);
	}*/
	
	$string = preg_replace("/$quote/", '', $string);
	
	$lines=explode("\n", $string);
        $string = trim($lines['0']);
		//echo $lines['0'];
    $quoteg = '##'; // GREEN UNDO
	$countg = substr_count($string, $quoteg);
	
    /*for ($i = 0; $i <= $countg/2; $i++) {
        $string = preg_replace("/$quoteg/", '', $string, 1);
	}*/
	
	$string = preg_replace("/$quoteg/", '', $string);
	
	$lines=explode("\n", $string);
        $string = trim($lines['0']);
		//END GREEN UNDO   
    $quoteg = '@@'; // purple UNDO
	$countg = substr_count($string, $quoteg);
    for ($i = 0; $i <= $countg/2; $i++) {
        $string = preg_replace("/$quoteg/", '', $string, 1);
	}
	$lines=explode("\n", $string);
        $string = trim($lines['0']);
		//END GREEN purple   
    return $string;
}    
    
?>