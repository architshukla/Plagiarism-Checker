<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<title> Logs and Statistics | Plagiarism Checker </title>
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
	<script>
	function getLogs()
	{
		var filename = "";
		<?php
			if(empty($_GET['file']))
			{
				echo "clearInterval(getLogsID);
				return;";
			}
			else
			{
				echo "var filename = '".$_GET['file']."';";
				$timestamp = substr($_GET['file'], 4);
			}
		?>
		var xmlhttp;
		if(window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
		 		if(xmlhttp.responseText.indexOf('stop') != -1)
		 		{
		 			var parts = xmlhttp.responseText.split('stop');
		 			var subparts = parts[1].split('~DELIM~');
		 			document.getElementById("logDiv").innerHTML=subparts[0];
		 			document.getElementById("outputLogDiv").innerHTML=subparts[1];
		 			document.getElementById('jumbotronText').innerHTML='Statistics <small><?php echo $_GET['filename']; ?> </small>';
		 			clearInterval(getLogsID);
		 			return;
		 		}
		 		var parts = xmlhttp.responseText.split("~DELIM~");
		 		document.getElementById("logDiv").innerHTML=parts[0];
		 		document.getElementById("outputLogDiv").innerHTML=parts[1];
		 	}
		}
		xmlhttp.open("GET","readLogs.php?file="+filename,true);
		xmlhttp.send();
	}

	function executeScripts()
	{
		<?php
			echo "var timestamp = $timestamp;";
		?>
		var xmlhttp;
		if(window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
		 		return;
		 	}
		}
		<?php
		if(empty($_GET['docx']))
			echo "xmlhttp.open('GET','executeScripts.php?timestamp='+timestamp,true);";
		else
			echo "xmlhttp.open('GET','executeScripts.php?timestamp='+timestamp+'&docx=1',true);"
		?>
		xmlhttp.send();
	}

	function redirectStats()
	{
		window.location = "stats.php?file=output_"+<?php echo "\"$timestamp\""; ?>;
	}

	var getLogsID = setInterval(getLogs,500);

	<?php
		if(!empty($_GET['file']) && !empty($_GET['search']) && $_GET['search'] == 1)
		{
			echo "executeScripts();";
		}
	?>

	</script>
</head>
<body>
    <div class="navbar navbar-inverse">
    	<div class="navbar-inner">
    		<a class="brand" href="javascript:void(0);">Plagiarism Checker</a>
    		<ul class="nav">
    			<li class="active"><a href="index.php">Home</a></li>
    			<li class="active"><a href="scripts/scripts.zip">Download Scripts!</a></li>
    			<li class='active'><a class='btn-primary' data-toggle='modal' href='#myModal'> View Log </a></li>
    		</ul>
	    </div>
    </div>

	<div class='hero-unit'>
		<?php 
			if(empty($_GET['file']))
			{
				echo "<h1> File not selected <small> Enter a file name as a GET parameter </small></h1>";
				exit();
			}
		?>
		<h1 id='jumbotronText'> Processing <small><?php echo $_GET['filename']; ?> </small></h1>
	</div>
	<div class='well' id='logDiv' style='margin:20px'>
	</div>

	

	<div id='myModal' class="modal hide fade">
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h3>Plagiarism Checker - Script Logs</h3>
    	</div>
    	<div class="modal-body" id='outputLogDiv'>
    		<p>No logs found.</p>
    	</div>
    	<div class="modal-footer">
    		<a href="#" data-dismiss="modal" class="btn btn-primary">Close</a>
    	</div>
    </div>
</body>
</html>
