<?php
	if(empty($_GET['timestamp']))
		return;
	$time = $_GET['timestamp'];
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
		if(empty($_GET['docx']))
			shell_exec($configs['pythonPath']."\python.exe scripts\main.py temp\input_$time temp\output_$time > temp\log_$time");
		else
			shell_exec($configs['pythonPath']."\python.exe scripts\main.py temp\input_$time.docx temp\output_$time > temp\log_$time");
	}
	else
	{
		if(empty($_GET['docx']))
			shell_exec("python scripts/main.py temp/input_$time temp/output_$time > temp/log_$time 2>&1 &");
		else
			shell_exec("python scripts/main.py temp/input_$time.docx temp/output_$time > temp/log_$time 2>&1 &");
	}
?>	