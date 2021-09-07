<?php include("header.php")?>
<?php include "../DB/database.php";?>
<!-- Main Content section Start       -->
<div class="main">
    <div class="content-area">
        <h1 class="service-heading">Select a service</h1>
        <div class="service-grid">
            <div class="service-filter">
                <p>Filter services: </p>
                <div>
                    <select id="filter" name="service-filter">
						<?php getFilterOptions(); ?>
                    </select>
                </div>
            </div>
            <div class="show-all "><?php showServices();?> </div>
            <div class="show-inside hide"><?php showServices('inside');?> </div>
            <div class="show-outside hide"><?php showServices('outside');?> </div>
        </div>
    </div>
</div>

<!-- Main  content section End       -->

<?php /****************************************************************************************************************
													page functions
***********************************************************************************************************************/




function getFilterOptions(){
	
	
	echo "<option value='all_services'>All Services</option>";
	
	$query = "
				SELECT DISTINCT service_type
				FROM services
			 ";
	$dbc = db_connect();
	
		if ( $r = mysqli_query( $dbc, $query ) ) {
			while ( $record = mysqli_fetch_array( $r ) ) {
				
				
			$type = $record['service_type'];
			$value = strtolower($type."_services");
				echo "<option value='$value'>$type</option>";
			}
			
			
		}
	
	
	db_disconnect($dbc);
	
}










function showServices($type){

	switch($type){
		case 'inside':
		$query = "
					SELECT service_image AS image,
						   service_name AS service,
						   service_description AS description,
						   service_id,
						   service_rate AS rate
					FROM services
					WHERE service_type = 'inside';
					";
		break;
		case'outside':
			$query = "
					SELECT service_image AS image,
						   service_name AS service,
						   service_description AS description,
						   service_id,
						   service_rate AS rate
					FROM services
					WHERE service_type = 'outside';
					";
		break;
		default:
			$query = "
					SELECT service_image AS image,
						   service_name AS service,
						   service_description AS description,
						   service_id,
						   service_rate AS rate
					FROM services
					";		
	}
	

	
		$dbc = db_connect();

		//run query
		if ( $r = mysqli_query( $dbc, $query ) ) {
			
			
			  //start tags
    echo("
        <div class=\"outside-services\">
            <ul>
        ");
			
			
			while ( $record = mysqli_fetch_array( $r ) ) {
				
				$image = $record['image'];
				$s_name = $record['service'];
				$overview = $record['description'];
				$serv_id = $record['service_id'];
				$rate = $record['rate'];
				
				//create url
				$page_name = strtolower( str_replace( ' ', '', $s_name ) );
				$url = './service_pages/' . $page_name . '.php';
				
				$image_src  ="src='./uploads/$image' alt='service'";
				
				
				 //li loop
			 echo("

					<li>
						<div class=\"service-div\">
							<a href=\"$url\"><img $image_src /></a>
							<p class=\"grid-item-desc\">$s_name</p>
							<p>Per hour Rate <span>$rate</span></p>
						</div>
					</li>     

				"); 
				
				
				
				
			} //end of query fetch loop
			
			  //ending tags
     echo("
            </ul>
        </div>
        ");
			
		}//end of query run
	
	db_disconnect($dbc);
	
}//end of showServices function

?>








<?php include("social.php")?>

<?php include("footer.php")?>




