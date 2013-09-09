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
		shell_exec($configs['pythonPath']."\python.exe scripts\main.py temp\input_$time temp\output_$time 1> temp\log_$time");
	}
	else
	{
		shell_exec("python scripts/main.py temp/input_$time temp/output_$time > temp/log_$time 2>&1 &");
	}
?>