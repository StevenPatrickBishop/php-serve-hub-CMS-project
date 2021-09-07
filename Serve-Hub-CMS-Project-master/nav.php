<div class="nav">
	<div class="logo">
		<img src="images/logo.png" alt="logo"/>  
		<h4>The Serve-Hub</h4>
		
	</div>
		<ul class="nav-links">
			<li><a href="index.php">Home</a></li>
			<li><a href="about.php">About</a></li>
			<li><a href="select_service.php">Services</a></li>
			
			<li><a href="login.php">login</a></li>
<!--
			<li><a href="JoinTeam.php">Join</a></li>
			<li><a href="SelectService.php">Scheduling</a></li>
			<li><a href="Tesimonials.php">Testimonials</a></li>
			<li><a href="team-login.php">Login</a></li>
-->

		</ul>
			<div class="burger">
			<div class="line1"></div>
			<div class="line2"></div>
			<div class="line3"></div>
			</div>
	<?php

		
		if(isset( $_SESSION['active_user'])){
			
			$user_role = $_SESSION['active_user']['role'];
			$active_user = $_SESSION['active_user']['first_name'];
			$active_user_id = $_SESSION['active_user']['user_id'];

			if($user_role != 'guest'){
			
			echo "<div class='logout-head'>
				   <button class='button-reverse'><a href='logout.php'>Log out here</a></button>
				</div>";
			}
			
			
			if($user_role == 'customer'){
			echo "<div class='logged-in'>
			<ul class='user-link'>
				<li><p>User: $active_user - $active_user_id</p></li>
				<li><a href='shopping_cart.php'>Shopping Cart</a></li>
			</ul>
			
			</div>";	
			}
			
		}
	?>

	
</div>

	<?php
		
		if(isset( $_SESSION['active_user'])){
			
			$user_role = $_SESSION['active_user']['role'];
			
			if($user_role == 'admin'){
				echo "<div class='show-dashboard-link'>
				<ul class='nav-links dash'><li><a href='cms.php'>CMS Dashboard Link-Admin</a></li></ul>
				</div>";
			}
			if($user_role == 'publisher'){
				echo "<div class='show-dashboard-link'>
				<ul class='nav-links dash'><li><a href='cms_publisher.php'>CMS Dashboard Link-Publisher</a></li></ul>
				</div>";
			}
			
			
		}
	?>