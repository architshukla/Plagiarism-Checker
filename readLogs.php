<?php
	if(empty($_GET['file']))
	{
		return;
	}

	$handle = fopen("temp/".$_GET['file'], "r");
	$string = fread($handle, filesize("temp/".$_GET['file']));
	$string = str_replace("...", "...<br>", $string);

	$parts = explode("\r", $string);

	foreach ($parts as $part)
	{
		$nums = explode("/",$part);
		if(count($nums) < 2)
			continue;
		else
		{
			$value = $nums[0];
			$value = $value/15*100;
		}
	}
	$div = "<div class='progress progress-success active progress-striped'> <div class='bar' style='width:$value%'></div></div>";
	$string .= "~".$div;

	if(strpos($string, "Done!"))
	{
		$string .="stop";
	}

	echo $string;
?>