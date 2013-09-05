<?php
	if(!isset($_FILES['file']))
		header('Location: index.php');
			
	if(empty($_GET['file']))
	{
		if ($_FILES['file']['type'] != 'text/plain')
		{
			echo "<h2> Only text files are supported.</h2>";
			exit();
		}
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
			shell_exec("".$configs['pythonPath']."\python.exe scripts\main.py temp\input_$time temp\output_$time > temp\log_$time 2>&1 ");
		}
		else
		{
			shell_exec("python scripts/main.py temp/input_$time temp/output_$time > temp/log_$time 2>&1 &");
		}
		header("Location: logs.php?file=log_$time");
	}
?>
