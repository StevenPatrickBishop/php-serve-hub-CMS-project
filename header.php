<?php session_start(); ?>
<?php ob_start(); ?>

<?php
	if(!isset($_SESSION['active_user'])){
		
	$_SESSION['active_user'] = [
	'user' 	     => 'guest',
	'role' 	     => 'guest',
	'first_name' => 'guest',
	'last_name'  =>'guest',
	'user_id'    => 5,
	'email' => 		''
	];

		
	}


		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>The Serve-Hub</title>
      <link rel="stylesheet" href="styles/style.css"/>
	  <link rel="stylesheet" href="../styles/style.css"/>
      <!--[if IE]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
     
   </head>
   <body>
	   
	   <?php $_SESSION['current_user'] = 5;  ?> 

<?php include("util/function.php")?>
<?php include("nav.php")?>

	   