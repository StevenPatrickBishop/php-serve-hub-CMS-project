<?php include("header.php")?>
<?php include "../DB/database.php";?>





<div class="main ">
<div class="content-area">
<div class='login-container'>
	<h1>Login Here</h1>


<!--handle form-->

<?php

		
	if(isset($_POST['login'])){
		
		$error = false;
		
		if(empty($_POST['username'])){
		  $error = true;
		}
		if(empty($_POST['password'])){
		  $error = true;
		}
		
		
		if(!$error){
			$user_passed_in = $_POST['username'];
			$password_passed_in = $_POST['password'];
				
			
			$query ="
			SELECT * from users
			WHERE username = '$user_passed_in'
			AND password = '$password_passed_in'
			";
			
			$dbc = db_connect();
			
			$_SESSION['active_user'] = [];	
			
			if ( $r = mysqli_query( $dbc, $query ) ) {
				while ( $record = mysqli_fetch_array( $r ) ){
					$account_exists	 = true;
					
					
					$_SESSION['active_user']['user'] 	= $record['username'];
					$_SESSION['active_user']['role']		= $record['role'];
					$_SESSION['active_user']['first_name']	= $record['first_name'];
					$_SESSION['active_user']['last_name'] 	= $record['last_name'];
					$_SESSION['active_user']['email']		= $record['email'];
					$_SESSION['active_user']['user_id']		= $record['user_id'];
				
				}
				
				if($account_exists){
					$user = $_SESSION['active_user']['user'];
					$user_role = $_SESSION['active_user']['role'];

					if($user_role == 'admin'){
						ob_end_clean();
						header("location: cms.php");
						exit();
					}
					if($user_role == 'publisher'){
						ob_end_clean();
						header("location: cms_publisher.php");
						exit();
					}
					if($user_role == 'customer'){
						ob_end_clean();
						header("location: select_service.php");
						exit();
					}

					
				
				}
				else{
					echo 'credentials did not return a match.';
				}
			
			}
			
			
			
			db_disconnect($dbc);
			
		}//empty test
	}//post test
	
	

?>




	
	<form action="" method="post">
		<div>
			
			<?php $u_value = isset( $_POST[ 'username' ] ) ? htmlspecialchars( $_POST[ 'username' ] ) : '';?>
			<p>Username:<input name='username' type='text'  value='<?php echo $u_value; ?>' /></p>
			<?php if(isset($_POST['login']) && empty($_POST['username']))
			{echo "<p class='error'>Username not set</p>";} ?>
			
		</div>
		<div>
			<?php $p_value = isset( $_POST[ 'password' ] ) ? htmlspecialchars( $_POST[ 'password' ] ) : '';?>
			<p>Password:<input type="password" name='password' value='<?php echo $p_value ?>' /></p>
			<?php if(isset($_POST['login']) && empty($_POST['password']))
			{echo "<p class='error'>password not set</p>";} ?>
		
		</div>
		<div>
			<p><input type="submit" name='login' value="login"/></p>
		</div>
	</form>
</div>
</div>
</div>



<?php include("social.php")?>
<?php include("footer.php")?>