<?php

	if(!isset($_FILES['file']))
		header('Location: index.php');
			
	if(empty($_GET['file']))
	{
		$mimes = array('text/plain','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf');

		if (!in_array($_FILES['file']['type'], $mimes))
		{
			echo "<h2> Only text / docx / pdf files are supported.</h2>";
			exit();
		}
		
		$time = time();
		
		if(strcmp($_FILES['file']['type'],'application/pdf')==0)
		{
		    if(substr(PHP_OS, 0, 3) == 'WIN')
		    {
		        echo "<h2> PDF support only on linux, currently. </h2>";
		        exit();
		    }
		    
		    else
		    {
		        move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time.pdf");
		        shell_exec("pdftotext temp/input_$time.pdf temp/input_$time");
		    }
		}
		
        else
        {
            if(strcmp($_FILES['file']['type'],'application/vnd.openxmlformats-officedocument.wordprocessingml.document')==0)
                move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time.docx");
            else
                move_uploaded_file($_FILES['file']['tmp_name'], "temp/input_$time");
        }
		header("Location: logs.php?file=log_$time&search=1");
	}
?>
