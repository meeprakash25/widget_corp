<?php 
	if(!isset($layout_context)){
		$layout_context = "public";
	}
?>
<! DOCTYPE html>
<html>
	<head>
		<title>widget corp <?php if($layout_context == "admin"){echo "Admin";} ?></title>
		<link rel="stylesheet" type="text/css" href="stylesheets/public.css" media="all">
	</head>

	<body>
		
		<div id="header">
			<h1>Widget Corp <?php if($layout_context == "admin"){echo "Admin";} ?></h1>
		</div>