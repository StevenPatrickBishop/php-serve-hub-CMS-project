<?php include("header.php") ?>
<?php error_reporting(E_ALL); ini_set('display_errors',1); ?>
<?php include "../DB/database.php";?>


<?php
/***************************************************************************************************************
												Add New Service Handler
***************************************************************************************************************/



if($_SESSION['active_user']['role'] != 'admin' ){
	header("location:unauthorized.php");
	
}//end of role check



if ( isset( $_POST[ 'add_service' ] ) ) {

	$error = false;

	if ( empty( $_POST[ 'add_service_name' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'add_service_description' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'add_service_overview' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'add_service_rate' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'add_service_type' ] ) ) {
		$error = true;
	}

	if ( !file_exists( $_FILES[ "s_image" ][ "tmp_name" ] ) ) {
		$error = true;
	}

	if ( !$error ) {

		//open db connection
		$dbc = db_connect();

		//validate form
		//set variables
		$s_name = mysqli_real_escape_string($dbc,$_POST[ 'add_service_name' ]);
		$s_description = mysqli_real_escape_string($dbc,$_POST[ 'add_service_description' ]);
		$s_overview = mysqli_real_escape_string($dbc,$_POST[ 'add_service_overview' ]);
		$s_rate = $_POST[ 'add_service_rate' ];
		$s_type = $_POST[ 'add_service_type' ];
		$s_tax = $_POST[ 'tax_state' ];


//
		// store image live site version
		if ( move_uploaded_file( $_FILES[ 's_image' ][ 'tmp_name' ], "../bishopwebcoding.com/uploads/{$_FILES['s_image']['name']}" ) ) {

			$file = $_FILES[ 's_image' ][ 'name' ];
		}

	

		
		
		//set query
		$query = "
		INSERT INTO services( 
    				service_name,
    				service_description,
    				service_overview,
					service_type,
    				service_image,
					service_rate,
					service_tax_code,
					template_id)
		VALUES(
			'$s_name',
			'$s_description',
			'$s_overview',
			'$s_type',
			'$file',
			$s_rate,
			(select tax_id from tax where tax_state = '$s_tax'),1)";


		//process query
		if ( @mysqli_query( $dbc, $query ) ) {
			echo "<p>$s_name service has been added</p>";
		} else {
			print '<p style="color: red;"> Service not added:<br />' . mysqli_error( $dbc ) . '.</p><p>The query being run was: ' . $query . '</p>';
		}

		//disconnect db
		db_disconnect( $dbc );



		//create php page for service
		$page_name = strtolower( str_replace( ' ', '', $s_name ) );
		$new = './service_pages/' . $page_name . '.php';

		if ( touch( $new ) ) {
			echo "<p>file: " . $page_name . ".php has been created</p>";
		}


		//open db connection
		$dbc = db_connect();

		//import template from database
		$query = "
		SELECT  template_body,
				service_name,
				service_id
		FROM 	templates t
		JOIN 	services s ON s.template_id = t.template_id
		WHERE 	service_name = '$s_name'";


		//load template markup into new service page
		if ( $page_body = mysqli_query( $dbc, $query ) ) {
			while ( $record = mysqli_fetch_array( $page_body ) ) {

				$service = $record[ 'service_id' ];
				$service = '<?php $service="' . $service . '" ?>';
				$header = '<?php include("../header.php")?>';
				$database = '<?php include("../../DB/database.php"); ?>';
				$data = $record[ 'template_body' ];
				$social = '<?php include("../social.php")?>';
				$footer = '<?php include("../footer.php")?>';
				echo "<p>retrieving data</p>";

				if ( file_exists( $new ) ) {
					echo "<p>writing to file</p>";
					file_put_contents( $new, $header . PHP_EOL );
					file_put_contents( $new, $database . PHP_EOL, FILE_APPEND );
					file_put_contents( $new, $service . PHP_EOL, FILE_APPEND );
					file_put_contents( $new, $data . PHP_EOL, FILE_APPEND );
					file_put_contents( $new, $social . PHP_EOL, FILE_APPEND );
					file_put_contents( $new, $footer . PHP_EOL, FILE_APPEND );
				}

			}

		}


		

		//disconnect db
		db_disconnect( $dbc );



		//redirect user
		ob_end_clean();
		header( "location: $new" );
		exit();

	} //end of valid code





} //end of add service



/***************************************************************************************************************
												Update Existing Service Handler
***************************************************************************************************************/

if ( isset( $_POST[ 'update_service' ] ) ) {

	$error = false;

	//validate form
	if ( empty( $_POST[ 'update_service_name' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'update_service_description' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'update_service_type' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'update_service_overview' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'update_service_rate' ] ) ) {
		$error = true;
	}



	if ( !$error ) {


		//set variables
		$s_name = $_POST[ 'update_service_name' ];
		$s_description = $_POST[ 'update_service_description' ];
		$s_overview = $_POST[ 'update_service_overview' ];
		$s_rate = $_POST[ 'update_service_rate' ];
		$s_tax = $_POST[ 'tax_state' ];
		$s_image = $_POST[ 'image' ];
		$s_type = $_POST[ 'service_type' ];
		$p_name = $_POST[ 'page_name' ];
		$s_id = $_POST[ 'id' ];


		$dbc = db_connect();

		if ( file_exists( $_FILES[ "s_image" ][ "tmp_name" ] ) ) {

			//remove old image
			$image_url = "./uploads/$s_image";
			unlink( $image_url );

			// store new image
			if ( move_uploaded_file( $_FILES[ 's_image' ][ 'tmp_name' ],
					"../bishopwebcoding.com/uploads/{$_FILES['s_image']['name']}" ) ) {
				//set new image
				$file = $_FILES[ 's_image' ][ 'name' ];
			}
			//query if changing image
			$query = "
				UPDATE services
				SET service_name = '$s_name',
					service_description = '$s_description',
    				service_overview = '$s_overview',
    				service_image = '$file',
    				service_rate = '$s_rate',
					service_type = '$s_type'
				WHERE service_id = '$s_id';
			";
			echo( $query );
			//process query
			@mysqli_query( $dbc, $query );
			db_disconnect( $dbc );


		} else {
			//query if image remains the same	
			$query = "
					UPDATE 	services
					SET 	service_name = '$s_name',
							service_description = '$s_description',
							service_overview = '$s_overview',
							service_rate = '$s_rate',
							service_type = '$s_type'
					WHERE 	service_id = '$s_id';
					";
			echo( $query );
			//process query
			@mysqli_query( $dbc, $query );
			db_disconnect( $dbc );
		}

		//rename file		
		$old_page_name = strtolower( str_replace( ' ', '', $p_name ) );
		$old_page_url = './service_pages/' . $old_page_name . '.php';

		$new_page_name = strtolower( str_replace( ' ', '', $s_name ) );
		$new_page_url = './service_pages/' . $new_page_name . '.php';

		rename( $old_page_url, $new_page_url );
		
		//redirect user
		ob_end_clean();
		header( "location: $new_page_url" );
		exit();


	}

}



/***************************************************************************************************************
												EDIT ABOUT PAGE Handler
***************************************************************************************************************/

if(isset($_POST['submit_body_about'])){
	
	$error = false;

	if(empty($_POST['page_heading_about'])){
		$error = true;
	}

	if(empty($_POST['page_body_about'])){
		$error = true;
	}


	if(!$error){

		$t_name = $_POST['page_heading_about'];
		$t_body = $_POST['page_body_about'];

		$dbc = db_connect();
		$t_name = mysqli_real_escape_string($dbc,$t_name);
		$t_body = mysqli_real_escape_string($dbc,$t_body);

		$query ="
		UPDATE templates
		SET template_name ='$t_name',
			template_body = '$t_body'
		WHERE
			template_id = 2;
		";


		//process query
		mysqli_query( $dbc, $query );
	
		//disconnect
		db_disconnect($dbc);
		
		//redirect

		ob_end_clean();
  		header( 'Location: about.php' ) ;
		exit();


	}

}




/***************************************************************************************************************
												Delete Service Handler
***************************************************************************************************************/
if ( isset( $_POST[ 'delete_service' ] ) ) {

	if ( !empty( $_POST[ 'select_for_delete' ] ) ) {
		$service = $_POST[ 'select_for_delete' ];


		/*--------------------------------delete page resources from directories-------------------------------------------*/

		$dbc = db_connect();
		$query = "
					SELECT service_name,
						   service_image
					FROM services
					WHERE service_id = $service;
			";

		//run query
		if ( $r = mysqli_query( $dbc, $query ) ) {
			while ( $record = mysqli_fetch_array( $r ) ) {

				//get service url
				$page_name = $record[ 'service_name' ];
				$page_name = strtolower( str_replace( ' ', '', $page_name ) );
				$page_url = './service_pages/' . $page_name . '.php';

				//get service image
				$service_image = $record[ 'service_image' ];
				$image_url = "./uploads/$service_image";

				echo "removing $page_url";
				echo "removing $image_url";
				unlink( $page_url );
				unlink( $image_url );

			}
		}

		//close connnection
		db_disconnect( $dbc );


		/*------------------------------------------delete service from database-------------------------*/


		$dbc = db_connect();
		$query = "
					DELETE FROM services
					WHERE service_id = $service;
			";

		echo "deleting $service";
		//run query
		mysqli_query( $dbc, $query );

		//close connnection
		db_disconnect( $dbc );


	} //end of valid code

} //end delete section


/***************************************************************************************************************
												Add user Handler
***************************************************************************************************************/


if(isset($_POST['add_user_submit'])){

	$error = false;


	if(empty($_POST['add_username'])){
		$error = true;
	}
	if(empty($_POST['add_password'])){
		$error = true;
	}
	if(empty($_POST['add_role'])){
		$error = true;
	}
	if(empty($_POST['add_firstName'])){
		$error = true;
	}
	if(empty($_POST['add_lastName'])){
		$error = true;
	}
	if(empty($_POST['add_email'])){
		$error = true;
	}

	if(!$error){

		$username 	= $_POST['add_username'];
		$password 	= $_POST['add_password'];
		$role 		= $_POST['add_role'];
		$first_name = $_POST['add_firstName'];
		$last_name 	= $_POST['add_lastName'];
		$email 		= $_POST['add_email'];


		$query = "

		INSERT INTO users(
					username,
					password,
					role,
					first_name,
					last_name,
					email
		)
		VALUES(
					'$username',
					'$password',
					'$role',
					'$first_name',
					'$last_name',
					'$email');";


		$dbc = db_connect();


		//run query
		mysqli_query( $dbc, $query );

		db_disconnect($dbc);



		//redirect

		// ob_end_clean();
  		// header( 'Location: user_updated.php' ) ;
		// exit();

		

	}//end of error check

}//end of post check




/***************************************************************************************************************
												update user Handler
***************************************************************************************************************/



if(isset($_POST['update_user_submit'])){

	$error = false;

	if(empty($_POST['update_username'])){
		$error = true;
	}
	if(empty($_POST['update_password'])){
		$error = true;
	}
	if(empty($_POST['update_role'])){
		$error = true;
	}
	if(empty($_POST['update_firstName'])){
		$error = true;
	}
	if(empty($_POST['update_lastName'])){
		$error = true;
	}
	if(empty($_POST['update_email'])){
		$error = true;
	}
	if(!$error){

		
		$username 	= $_POST['update_username'];
		$password 	= $_POST['update_password'];
		$role 		= $_POST['update_role'];
		$first_name = $_POST['update_firstName'];
		$last_name 	= $_POST['update_lastName'];
		$email 		= $_POST['update_email'];
		$id			= $_POST['id'];


		$query = "
		UPDATE users
		SET 	username = '$username',
				password = '$password',
				role	 = '$role',
				first_name = '$first_name',
				last_name = '$last_name',
				email = '$email'
		WHERE	user_id = '$id';

		";
		


		$dbc = db_connect();
		//run query
		mysqli_query( $dbc, $query );

		db_disconnect($dbc);




// //redirect

// ob_end_clean();
// header( 'Location: user_updated.php' ) ;
// exit();





		
	}
}

/***************************************************************************************************************
												delete user Handler
***************************************************************************************************************/

if(isset($_POST['remove_user_submit'])){

	$error = false;
	if(empty($_POST['user_list_remove'])){
		$error = true;
	}

	if(!$error){

		$user = $_POST['user_list_remove'];//user id

		$query = "
			DELETE FROM users
			WHERE user_id = '$user';

		";
		


		$dbc = db_connect();

		//run query
		mysqli_query( $dbc, $query );

		db_disconnect($dbc);

		//redirect

		// ob_end_clean();
  		// header( 'Location: user_updated.php' ) ;
		// exit();



		
	}
}


?>



<?php include "./cms_dashboard.php";?>

