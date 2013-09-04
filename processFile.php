<?php
	if(!isset($_FILES['file']))
		header('Location: index.php');		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<title> Plagiarism Checker | Statistics </title>
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
		<h1> Statistics <small><?php echo $_FILES['file']['name']; ?> </smalle></h1>
	</div>
	<div class='well' style='margin:20px'>
		<h4>Similarity: Top 5 documents</h4>
		<?php
			// Check file type

			$time = time();
			move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time");
			if(substr(PHP_OS, 0, 3) == 'WIN')
			{
				$handle = fopen("config/config.txt","r");
				while(!feof($handle))
				{
					$line = fgets($handle);
					$parts = explode("=", $line);
					$configs[$parts[0]]=$parts[1];
				}
				fclose($handle);
				echo $configs['pythonPath']."\python.exe scripts\main.py temp\input_$time temp\output_$time";
				shell_exec("start cmd /k".$configs['pythonPath']."\python.exe scripts\main.py temp\input_$time temp\output_$time");
			}
			else
			{
				shell_exec("python scripts/main.py temp/input_$time temp/output_$time");
			}

			$handle = fopen("temp/output_$time", "r");
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
