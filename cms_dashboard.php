<?php include("components/form_components.php"); ?>



<!------------------------------------add form------------------------------------------>
<div class="main">
  <div class="content-area cms_dash">
<h1>CMS Dasboard - Admin Portal</h1>
<hr/>

<h2 id="add_service">Add New Service</h2>
<form action="#add_service" enctype="multipart/form-data" method="post">
	<div><?php showTextInput('tbl_add_service_name','lbl_add_service_name','Service-Name','input_add_service_name','add_service_name','',false)?></div>
    
	<div>
  <?php showTextArea('tbl_add_service_description','lbl_add_service_description', $p_text = 'Service Description','input_add_service_description', 'add_service_description', $t_value='',false)?>
    </div>
    <div>
  <?php showTextArea('tbl_add_service_overview','lbl_add_service_overview','Service Overview','input_add_service_overview','add_service_overview','',false)?>
    </div>
    <div>
      <?php showTextInput('tbl_add_service_rate','lbl_add_service_rate','Service Rate$','input_add_service_rate','add_service_rate','',false)?>
    </div>
    <div>
      <p>Service Type:
        <select name="add_service_type">
          <option value="">Type</option>
          <option value="Inside">Inside</option>
          <option value="Outside">Outside</option>
          </select>
      </p>
    </div>
    <div>
      <p>Tax State:
        <select name="tax_state">
          <option value="CT">CT</option>
          </select>
      </p>
    </div>
    <div>
      <p>Add Image: <input type="file" name="s_image" accept="image/*"></p>
      <p>Optimal image size = 400 x 600 px</p>
    </div>
    <div>
      <input type="hidden" name="add_service" value="addNew">
      <input type="submit" value="Add Service">
    </div>

</form>


<hr/>




<!------------------------------------update form------------------------------------------>

<h2 id="update_service">Update Service</h2>

<form action="#update_service" method="post">
    <div>
      <select name='select_for_update'>
        <option value="">Select Service</option>
        <?php
		//open db connection
		$dbc = db_connect();

		//query for all services
		$query = "
						SELECT 	service_id, 
								service_name 
						FROM   	services
						";
		//run query
		if ( $r = mysqli_query( $dbc, $query ) ) {
			while ( $record = mysqli_fetch_array( $r ) ) {
				$service = $record[ 'service_id' ];
				$name = $record[ 'service_name' ];
				echo "<option value ='$service'>$name</option>";
			}
		}

		db_disconnect( $dbc );
		?>
      </select>
    </div>
    <div>
      <input type="hidden" name="get_service_to_update" value="update">
      <input type="submit" value="Update">
    </div>
</form>

<?php
if(isset($_POST['get_service_to_update']) && !empty($_POST['select_for_update'])){
				
		
	$id = $_POST['select_for_update'];
	
	$dbc = db_connect();
	
	$query = "
				SELECT 	service_id,
				service_name,
				service_type,
				service_description,
				service_overview,
				service_rate,
				service_image
				FROM 	services
				WHERE	service_id = '$id'";

				//run query
				if ( $r = mysqli_query( $dbc, $query ) ) {
				while ( $record = mysqli_fetch_array( $r ) ) {
				$name = $record[ 'service_name' ];
				$type = $record[ 'service_type' ];
				$decription = $record[ 'service_description' ];
				$overview = $record[ 'service_overview' ];
				$rate = $record[ 'service_rate' ];
				$image = $record[ 'service_image' ];
					
		    }
		}
					
?>
					
				<form action="" enctype="multipart/form-data" method="post">
                
				<div>
                  <?php showTextInput( 'tbl_update_service_name', 'lbl_update_service_name', 'Service Name', 'input_update_service_name', 'update_service_name', $name, true );?>
                </div>
					
                <div>
                  <?php showTextArea( 'tbl_update_service_description', 'lbl_update_service_description', 'Service Description', 'input_update_service_description', 'update_service_description', $decription, true );?>
                </div>
					
                <div>
				  <?php showTextArea( 'tbl_update_service_overview', 'lbl_update_service_overview', 'Service Overview', 'input_update_service_overview', 'update_service_overview', $overview, true ); ?>
                </div>
                <div>
                  <?php showTextInput( 'tbl_update_service_rate', 'lbl_update_service_rate', 'Service Rate$', 'input_update_service_rate', 'update_service_rate', $rate, true ); ?>
                </div>
				<div>
			  <p>Service Type:
				<select name="update_service_type">
				  <option value="">Type</option>
				  <option value="Inside">Inside</option>
				  <option value="Outside">Outside</option>
			    </select>
			  </p>
	  		 </div>
                <div>
                  <p>Tax State: <select name="tax_state"><option value="CT">CT</option></select></p>
                </div>
                <div>
				  <p>Add Image: <input type="file" name="s_image" accept="image/*">	
				  <p>Optimal image size = 400 x 600 px</p>
                </div>
                <div>
                  <input type="hidden" name='update_service' value='update'/>
                  <input type="hidden" name="image" value="<?php echo $image ?>"/>
                  <input type="hidden" name="page_name" value="<?php echo $name ?>"/>
                  <input type="hidden" name="service_type" value="<?php echo $type ?>"/>
                  <input type="hidden" name="id" value="<?php echo $id ?>"/>
                  <input type="submit" value="Update"/>
                </div>
				</form>
				
		
	
	<?php

db_disconnect($dbc);
}
?>

<hr/>



<!------------------------------------delete form------------------------------------------>

<h2 id="delete_service">Delete Service</h2>
<form action="#delete_service" method="post">
    <div>
      <select name='select_for_delete'>
        <option value="">Select Service</option>
        <?php
		//open db connection
		$dbc = db_connect();

		//query for all services
		$query = "
						SELECT 	service_id, 
								service_name 
						FROM   	services
						";
		//run query
		if ( $r = mysqli_query( $dbc, $query ) ) {
			while ( $record = mysqli_fetch_array( $r ) ) {
				$service = $record[ 'service_id' ];
				$name = $record[ 'service_name' ];
				echo "<option value ='$service'>$name</option>";
			}
		}

		db_disconnect( $dbc );
		?>
      </select>
    </div>
    <div>
      <input type="hidden" name="delete_service" value="delete">
      <input type="submit" value="Delete">
    </div>
</form>
<hr/>

<h2>Update About Page</h2>

<?php

$query = "
		SELECT * FROM templates
		WHERE template_id = 2;
";

	$dbc = db_connect();

	$h_value = '';
	$b_value = '';

	//get query results
		if ( $page_body = mysqli_query( $dbc, $query ) ) {
			while ( $record = mysqli_fetch_array( $page_body ) ) {
				$h_value = $record['template_name'];
				$b_value = $record['template_body'];
			}
		}

	db_disconnect($dbc);
	
?>


<form action='' method='post'>
	<div>
		<p>Page name: <input type='text' name='page_heading_about' value='<?php echo $h_value; ?>'></p>
		<?php if(isset($_POST['page_heading_about']) && empty($_POST['page_heading_about']))
		{echo "<p class='error'>page heading not set</p>";} ?>
	</div>

	<div>
		<p>Page body - insert your html here</p>
		<textarea rows='20' cols='150' name='page_body_about'><?php echo($b_value); ?></textarea>
		<?php if(isset($_POST['page_body_about']) && empty($_POST['page_body_about']))
		{echo "<p class='error'>page body not set</p>";} ?>
	</div>

	<div>
		
		<p><input type='submit' name='submit_body_about' value='Submit Post'></p> 
	
		
	</div>
</form>
<hr/>




<!-- Add users -->

<h2 id='add_user'>Add User</h2>
<form action='#add_user' method='post'>
		<div>
			<?php $value = isset( $_POST[ 'add_username' ] ) ? htmlspecialchars( $_POST[ 'add_username' ] ) : '';?>
			<p>Username: <input type='text' name='add_username' value='<?php echo $value?>'/></p>
			<?php if(isset($_POST['add_username']) && empty($_POST['add_username']))
		{echo "<p class='error'>Username not set</p>";} ?>
		</div>

		<div>
		<?php $value = isset( $_POST[ 'add_password' ] ) ? htmlspecialchars( $_POST[ 'add_password' ] ) : '';?>
			<p>Password: <input type='text' name='add_password' value='<?php echo $value?>'/></p>	
			<?php if(isset($_POST['add_password']) && empty($_POST['add_password']))
		{echo "<p class='error'>Password not set</p>";} ?>
		</div>

		<div>
	
			<p>Role: 
			<select name='add_role'>
				<option value=''>Select Role</option>
				<option value='customer'>Customer</option>
				<option value='publisher'>Publisher</option>
				<option value='admin'>Admin</option>
			</select>
			</p>
	
			<?php if(isset($_POST['add_role']) && empty($_POST['add_role']))
		{echo "<p class='error'>Role not set</p>";} ?>
		</div>


		<div>
		<?php $value = isset( $_POST[ 'add_firstName' ] ) ? htmlspecialchars( $_POST[ 'add_firstName' ] ) : '';?>
			<p>First Name<input type='text' name='add_firstName' value='<?php echo $value?>'/></p>
			<?php if(isset($_POST['add_firstName']) && empty($_POST['add_firstName']))
		{echo "<p class='error'>First Name not set</p>";} ?>
		</div>

		<div>
		<?php $value = isset( $_POST[ 'add_lastName' ] ) ? htmlspecialchars( $_POST[ 'add_lastName' ] ) : '';?>
			<p>Last Name<input type='text' name='add_lastName' value='<?php echo $value?>'/></p>
			<?php if(isset($_POST['add_lastName']) && empty($_POST['add_lastName']))
		{echo "<p class='error'>Last Name not set</p>";} ?>
		</div>

		<div>
		<?php $value = isset( $_POST[ 'add_email' ] ) ? htmlspecialchars( $_POST[ 'add_email' ] ) : '';?>
			<p>Email<input type='text' name='add_email' value='<?php echo $value?>'/></p>
			<?php if(isset($_POST['add_email']) && empty($_POST['add_email']))
		{echo "<p class='error'>Email not set</p>";} ?>
		</div>

		<div>
			<p><input type='submit' name='add_user_submit' value='Add User'/></p>
		</div>
		
</form>
<hr/>


<!-- Update users -->

<h2 id='update_user'>Update User</h2>

<form action='#update_user' method='post'>
		<select name='user_list_update'>
			<option value=''>Select user</option>
			<?php
			
				$query ="	
						SELECT 	username,
							   	user_id
						FROM 	users
				";

					$dbc = db_connect();
					
					if ( $r = mysqli_query( $dbc, $query ) ) {
						while ( $record = mysqli_fetch_array( $r ) ) {
							$username = $record['username'];
							$user_id = $record['user_id'];
							echo "<option value='$user_id'>$username</option>";
						}
					}
					db_disconnect($dbc);
			?>
		</select>

		<div>
			<p><input type='submit' name='get_user_submit' value='Get User'/></p>
		</div>
		
</form>

<?php


if(isset($_POST['get_user_submit']) && !empty($_POST['user_list_update'])){

		$id = $_POST['user_list_update'];


		$query = "SELECT * FROM users WHERE user_id = '$id' ";

		

		$dbc = db_connect();

		if ($r = mysqli_query( $dbc, $query ) ) {
			while ( $record = mysqli_fetch_array( $r ) ) {
			
				$username 	= $record['username'];
				$password 	= $record['password'];
				$role 		= $record['role'];
				$first_name = $record['first_name'];
				$last_name 	= $record['last_name'];
				$email 		= $record['email'];

// 				$c_selected = ($role == "customer") ? 'selected' : "";
//                 $p_selected = ($role == "publisher" ? 'selected' : "";
//                	$a_selected = ($role == "admin") ? 'selected' : "";
				
				
			}
		}		



		db_disconnect($dbc);
?>

<form action='#update_user' method='post'>
		<div>
	
			<p>Username: <input type='text' name='update_username' value='<?php echo $username?>'/></p>
			<?php if(isset($_POST['update_username']) && empty($_POST['update_username']))
		{echo "<p class='error'>Username not set</p>";} ?>
		</div>

		<div>
		
			<p>Password: <input type='text' name='update_password' value='<?php echo $password?>'/></p>
			<?php if(isset($_POST['update_password']) && empty($_POST['update_password']))
		{echo "<p class='error'>Password not set</p>";} ?>	
		</div>

		<div>     
            
         <?php
				$c_selected = ('customer' == $role) ? "selected": ""; 
				$p_selected = ('publisher' == $role) ? "selected": ""; 
				$a_selected = ('admin' == $role) ? "selected": ""; 

				
			?>


            <p>Role: 
            <select name='update_role'>
                <option value=''>Select Role</option>
                <option value='customer' <?php echo $c_selected; ?> >Customer</option>
                <option value='publisher' <?php echo $p_selected; ?>   >Publisher</option>
                <option value='admin' <?php echo $a_selected; ?>  >Admin</option>
            </select>
            </p>
	
			<?php if(isset($_POST['update_role']) && empty($_POST['update_role']))
		{echo "<p class='error'>Role not set</p>";} ?>
		</div>

		<div>
		
			<p>First Name<input type='text' name='update_firstName' value='<?php echo $first_name?>'/></p>
			<?php if(isset($_POST['update_firstName']) && empty($_POST['update_firstName']))
		{echo "<p class='error'>First Name not set</p>";} ?>
		</div>

		<div>
	
			<p>Last Name<input type='text' name='update_lastName' value='<?php echo $last_name?>'/></p>
			<?php if(isset($_POST['update_lastName']) && empty($_POST['update_lastName']))
		{echo "<p class='error'>Last Name not set</p>";} ?>
		</div>

		<div>
		
			<p>Email<input type='text' name='update_email' value='<?php echo $email?>'/></p>
			<?php if(isset($_POST['update_email']) && empty($_POST['update_email']))
		{echo "<p class='error'>Email not set</p>";} ?>
		</div>

		<div>
		
			<p><input type='hidden' name='id' value='<?php echo $id?>'/></p>
			<p><input type='submit' name='update_user_submit' value='Update User'/></p>
		</div>
		
</form>
<hr/>


	

<?php

	}//if posted

?>


<hr/>



<!-- Delete users -->

<h2>Remove User</h2>
<form action='' method='post'>
		<select name='user_list_remove'>
			<option value=''>Select user</option>
			<?php
			
				$query ="	
						SELECT 	username,
							   	user_id
						FROM 	users
				";

					$dbc = db_connect();
					
					if ( $page_body = mysqli_query( $dbc, $query ) ) {
						while ( $record = mysqli_fetch_array( $page_body ) ) {
							$username = $record['username'];
							$user_id = $record['user_id'];
							echo "<option value='$user_id'>$username</option>";
						}
					}
					db_disconnect($dbc);
			?>
		</select>

		<div>
			<p><input type='submit' name='remove_user_submit' value='Remove User'/></p>
		</div>
		
</form>
<hr/>


</div>
</div>

 <?php include("social.php")?>
<?php include("footer.php") ?>