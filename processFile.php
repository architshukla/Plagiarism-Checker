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
			// shell_exec("python");
			// Move file to temp/
			// Open file
			// Parse it and get FileName, Link, Similarity% values
			$fileNames = array("FileName1","FileName2","FileName3","FileName4","FileName5");
			$links = array("[Link]","[Link]","[Link]","[Link]","[Link]");
			$similarity = array("80.5%","70.2%","50%","35.5%","20.9%");

			$colors = array("","danger","success","warning","info");

			for($i=0;$i<5;$i++)
			{
				echo "<p><b>$fileNames[$i] - $links[$i] - $similarity[$i]</b>
				<div class='progress progress-striped active progress-$colors[$i]'>
				<div class='bar' style='width:$similarity[$i]'></div>
				</div>";
			}
		?>
</body>
</html>
