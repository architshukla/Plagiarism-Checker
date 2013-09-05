<?php
	if(empty($_GET['file']))
	{
		return;
	}

	$handle = fopen("temp/".$_GET['file'], "r");
	$string = fread($handle, filesize("temp/".$_GET['file']));
	$string = str_replace("...", "...<br>", $string);
	if(strpos($string, "Done!"))
	{
		$string .="stop";
	}
	echo $string;
?>