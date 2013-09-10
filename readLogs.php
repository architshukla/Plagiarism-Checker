<?php
	if(empty($_GET['file']))
	{
		return;
	}

	$handle = fopen("temp/".$_GET['file'], "r");
	$string = fread($handle, filesize("temp/".$_GET['file']));

	if(strpos($string, "Done!"))
	{
		echo "stop";	
		$parts = explode("_",$_GET['file']);
		$filename = "output_$parts[1]";
		$handle = fopen("temp/$filename", "r");
		$count = 1;

		$links = array();

		while(!feof($handle))
		{
			$line = fgets($handle);
			if(trim($line) == "")
				continue;
			$parts = explode(" ",$line);

			$end = strpos($parts[1],"."); 
			$tempSimilarity = substr($parts[1], 0, $end + 3);
			if(intval($tempSimilarity) == 0)
				continue;
			$similarity[] = $tempSimilarity;

			$links[] = "<a href='$parts[0]'>Document $count</a>";

			$start = strpos($parts[0], "//");
			$end = strpos($parts[0], "/", $start + 3);
			$temp = substr($parts[0], $start+2, $end - $start - 2);
			$website[] = $temp;

			$count++;
		}

		$colors = array("","danger","success","warning","info");
		$color = 0;
		if(!$count)
		{
			echo "<h4> No Documents Found.</h4>";
		}
		else
		{
			echo "<h4>Similarity: Top ".count($links)." documents:</h4>";

			for($i=0;$i<count($links);$i++,$color++)
			{
				if($color > 4)
					$color = 0;
				echo "<h4>$links[$i] - Hosted on <u>$website[$i]</u> - $similarity[$i]%</h4>
				<div class='progress progress-striped active progress-$colors[$color]'>
				<div class='bar' style='width:".intval($similarity[$i])."%'></div>
				</div>";
			}
		}
		$string = str_replace("...", "...<br><br>", $string);
		echo "~DELIM~$string";

		fclose($handle);
		return;
	}

	$parts = explode("\r", $string);

	foreach ($parts as $part)
	{
		$nums = explode("/",$part);
		if(count($nums) < 2)
			continue;
		else
		{
			$numerator = $nums[0];
			$denominator = intval($nums[1]);
			$value = (int)($numerator/$denominator*100);
		}
	}
	$string = str_replace("...", "...<br><br>", $string);
	echo "<h2 class='text-info'>$value% Completed</h2><br><div class='progress progress-success active progress-striped'> <div class='bar' style='width:$value%'></div></div>~DELIM~$string";
?>