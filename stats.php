<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<title> Statistics | Plagiarism Checker </title>
	<link href = "assets/css/bootstrap.css" rel="stylesheet" media="screen">
	<script src = "assets/js/jquery.js"></script>
	<script src = "assets/js/bootstrap.min.js"></script>
	<style>
		input:focus 
		{
    		outline:0px !important;
    		-webkit-appearance:none;
        }
        a:focus 
		{
    		outline:0px !important;
    		-webkit-appearance:none;
        }
        button:focus 
		{
    		outline:0px !important;
    		-webkit-appearance:none;
        }
	</style>
</head>
<body>
	<div class='hero-unit'>
		<h1> Statistics <small><?php echo $_GET['file']; ?> </smalle></h1>
	</div>
	<div class='well' style='margin:20px'>
		
		<?php
			// Check file type

			if(empty($_GET['file']))
			{
				exit();
			}

			$filename = $_GET['file'];

			$handle = fopen("temp/$filename", "r");
			$count = 1;
			while(!feof($handle))
			{
				$line = fgets($handle);
				if(trim($line) == "")
					continue;
				$parts = explode(" ",$line);
				$links[] = "<a href='$parts[0]'>Document $count</a>";

				$start = strpos($parts[0], "//");
				$end = strpos($parts[0], "/", $start + 3);
				$temp = substr($parts[0], $start+2, $end - $start - 2);
				$website[] = $temp;

				$end = strpos($parts[1],".");
				$similarity[] = substr($parts[1], 0, $end + 3);

				$count++;
			}

			$colors = array("","danger","success","warning","info");
			$color = 0;

			echo "<h4>Similarity: Top ".count($links)." documents</h4>";

			for($i=0;$i<count($links);$i++,$color++)
			{
				if($color > 4)
					$color = 0;
				echo "<h4>$links[$i] - Hosted on <u>$website[$i]</u> - $similarity[$i]%</h4>
				<div class='progress progress-striped active progress-$colors[$color]'>
				<div class='bar' style='width:".intval($similarity[$i])."%'></div>
				</div>";
			}
			fclose($handle);
		?>
</body>
</html>
