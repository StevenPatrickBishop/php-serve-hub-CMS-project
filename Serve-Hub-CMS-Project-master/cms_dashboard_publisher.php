<?php include("components/form_components.php"); ?>



<div class="main">
  <div class="content-area cms_dash">
<h1>CMS Dasboard - Publisher Portal</h1>
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


<!------------------------------------Edit About Page------------------------------------------>

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
</div>
</div>

 <?php include("social.php")?>
<?php include("footer.php") ?>