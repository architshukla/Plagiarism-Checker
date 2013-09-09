<?php
	if(!isset($_FILES['file']))
		header('Location: index.php');
			
	if(empty($_GET['file']))
	{
		$mimes = array('text/plain');

		if (!in_array($_FILES['file']['type'], $mimes))
		{
			echo "<h2> Only text files are supported.</h2>";
			exit();
		}
		
		$time = time();

		move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time");
		header("Location: logs.php?file=log_$time&search=1");
	}
?>
