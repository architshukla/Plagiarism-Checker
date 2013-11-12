<?php

	if(!isset($_FILES['file']))
		header('Location: index.php');
			
	$docx = 0;

	if(empty($_GET['file']))
	{
		$mimes = array('text/plain','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf','application/msword','application/vnd.ms-powerpoint');

		if (!in_array($_FILES['file']['type'], $mimes))
		{
			echo "<h2> Only text / docx / pdf / ppt files are supported.</h2>";
			echo "<p>This file has MIME type: ".$_FILES['file']['type'];
			exit();
		}
		
		$time = time();
		
		// PDF
		if(strcmp($_FILES['file']['type'],'application/pdf') == 0)
		{
		    if(substr(PHP_OS, 0, 3) == 'WIN')
		    {
		        move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time.pdf");
		        shell_exec("scripts\pdftotext64 -enc UTF-8 temp\input_$time.pdf temp\input_$time");
		    }
		    
		    else
		    {
		        move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time.pdf");
		        shell_exec("pdftotext temp/input_$time.pdf temp/input_$time");
		    }
		}
		else
		{
			// DOCX
			if(strcmp($_FILES['file']['type'],'application/vnd.openxmlformats-officedocument.wordprocessingml.document') == 0)
        	{
            	move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time.docx");
            	$docx = 1;
        	}
        	// DOC
        	else if(strcmp($_FILES['file']['type'],'application/msword') == 0)
        	{
        		move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time.doc");
        		if(substr(PHP_OS, 0, 3) == 'WIN')
        			shell_exec("scripts\catdoc -d utf-8 temp/input_$time.doc > temp/input_$time");
        		else
        			shell_exec("catdoc -d utf-8 temp/input_$time.doc > temp/input_$time");
        	}
        	// PPT
        	else if(strcmp($_FILES['file']['type'],'application/vnd.ms-powerpoint') == 0)
        	{
        		move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time.ppt");
        		if(substr(PHP_OS, 0, 3) == 'WIN')
        			shell_exec("scripts\catppt -d utf-8 temp/input_$time.ppt > temp/input_$time");
        		else
        			shell_exec("catppt -d utf-8 temp/input_$time.ppt > temp/input_$time");
        	}
        	// TEXT
        	else
        	{
        		move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time");
        		$docx = 0;
        	}
        }        
        
        if($docx == 1)
        	header("Location: logs.php?filename=".$_FILES['file']['name']."&file=log_$time&search=1&docx=1");
        else
			header("Location: logs.php?filename=".$_FILES['file']['name']."&file=log_$time&search=1");
	}
?>
