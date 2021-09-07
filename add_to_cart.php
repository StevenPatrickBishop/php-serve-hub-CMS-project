<?php include("header.php") ?>
<?php error_reporting(E_ALL); ini_set('display_errors',1); ?>
<?php include "../DB/database.php";?>



<?php /***************************************************************************************************************
												validate
***************************************************************************************************************/



if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$error = false;
	
	if ( empty( $_POST[ 'request_service' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'request_month' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'request_day' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'request_year' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'request_hour' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'request_minute' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'request_meridiem' ] ) ) {
		$error = true;
	}
	if ( empty( $_POST[ 'request_hours_needed' ] ) ) {
		$error = true;
	}
	
	//check date format
	//check time format
	
	
	if(!$error){
		
		//format date before insertion YYYY-MM-DD
		$day = $_POST['request_day'];
		$month = $_POST[ 'request_month' ];
		$year = $_POST[ 'request_year' ];
		
		$month = (strlen($month) == 1) ?  "0".$month : $month;
		$day = (strlen($day) == 1) ?  "0".$day : $day;
		
		$sql_date = $year."-".$month."-".$day; 
		
		
		//format Time before insertion YYYY-MM-DD
		$hour = $_POST[ 'request_hour' ];
		$minute = $_POST[ 'request_minute' ];
		$meridiem = strtoupper($_POST[ 'request_meridiem' ]);
		
		$minute = ($minute == 1) ?  $minute-1 : $minute;
		$minute = (strlen($minute) == 1) ?  "0".$minute : $minute;
		
		$sql_time = $hour.":".$minute." ".$meridiem;
		
		
		$r_need = $_POST[ 'request_hours_needed' ];
		$r_service = $_POST[ 'request_service' ];
		
		
		
		//add request to Database
		
		//user 5 is guest user - to be updated with session user
		
		$active_user = $_SESSION['active_user']['user_id'];	
				
		
		$query ="
				INSERT INTO requests(
							request_date,
							request_start,
							request_hours,
							request_service,
							user_id)
				Values(		'$sql_date',
							'$sql_time',
							'$r_need',
							'$r_service',
							'$active_user')";
		
		
			//open db connection
			$dbc = db_connect();
			//run query
		 	@mysqli_query( $dbc, $query );
			//disconnect db
			db_disconnect( $dbc );

		
		
	
		ob_end_clean();
  		header( 'Location: shopping_cart.php' ) ;
		exit();

		
	}else{
		$error_message = "<p class='error'>Not all fields are filled out</p>";
	}
	
}







?>



<?php/***************************************************************************************************************
												Add to cart
***************************************************************************************************************/?>
<div class="main">
  <div class="content-area schedule-service">
    <h2>Would you like to schedule a service?</h2>
    
    <form action="" method="post">
      
      <!--Choose Service-->
      <?php $r_service = isset($_POST['adding']) ? $_POST['request_service'] : ''?>
      <div>
  		<p>Choose Service: <select name='request_service'><?php showServicesOptions($r_service); ?></select></p>
      </div>
      <div>
        <table>
          <!--Choose Date-->
          <tr>
            <?php $r_month = isset($_POST['adding']) ? $_POST['request_month'] : ''?>
            <?php $r_day = isset($_POST['adding']) ? $_POST['request_day'] : ''?>
            <?php $r_year = isset($_POST['adding']) ? $_POST['request_year'] : ''?>
            
            <td><p>Pick a date:</p></td>
            <td><select name="request_month"><?php getMonthOptions($r_month); ?></select></td>
            <td><p></p></td>
            <td><select name="request_day"><?php getDayOptions($r_day); ?></select></td>
            <td><p></p></td>
            <td><select name="request_year"><?php getYearOptions($r_year,2); ?></select></td>
            </tr>
          <!--Choose Time-->
          <tr>
            <?php $r_hour = isset($_POST['adding']) ? $_POST['request_hour'] : ''?>
            <?php $r_minute = isset($_POST['adding']) ? $_POST['request_minute'] : ''?>
            <?php $r_meridiem = isset($_POST['adding']) ? $_POST['request_meridiem'] : ''?>
            <td><p>Pick a Time: </p></td>
            <td><select name="request_hour"><?php getHourOptions($r_hour); ?></select></td>
            <td><p>:</p></td>
            <td><select name="request_minute"><?php getMinuteOptions($r_minute); ?></select></td>
            <td><p></p></td>
            <td><select name="request_meridiem"><?php getMeridiemOptions($r_meridiem); ?></select></td>
            </tr>
          <!--Choose Hours Needed-->
          <tr>
            <td><p>Hours you need us: </p></td>
            <td><select name="request_hours_needed"><?php getNeededOptions(); ?></select></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
          </table>
		   <?php if(isset($error_message)){echo $error_message;}?>
     	 <p>Services can be scheduled for up to 8 hours per day</p>
      </div>
      <div>
        <input type="hidden" name="adding" value="scheduled">
        <input type="submit" value="Add To Cart">
      </div>
    </form>
  </div>
</div>
 <?php include("social.php")?>
 <?php include("footer.php")?>




<?php 
/*********************************************************************************************************************
													page functions
***********************************************************************************************************************/

	
function getMonthOptions($selected = ''){
	
	
	
//	$months =[
//		 1 	=> 'Jan',
//		 2 	=> 'Feb',
//		 3 	=> 'Mar',
//		 4 	=> 'Apr',
//		 5 	=> 'May',
//		 6 	=> 'Jun',
//		 7 	=> 'Jul',
//		 8 	=> 'Aug',
//		 9 	=> 'Sep',
//		10 	=> 'Oct',
//		11 	=> 'Nov',
//		12 	=> 'Dec'
//	];
//	
	
	
//		echo "<option value=''>Month</option>";
//		foreach($months as $m){
//		
//		$sel = ($m == $selected) ? 'selected' : ''; 
//		
//		echo "<option value=$m $sel >$m</option>";
//		}
//	
	
	
	echo "<option value=''>Month</option>";
	
	$months =[
		[1,'Jan' ],
		[2,'Feb'],
		[3,'Mar'],
		[4,'Apr'],
		[5,'May'],
		[6,'Jun'],
		[7,'Jul'],
		[8,'Aug'],
		[9,'Sep'],
		[10,'Oct'],
		[11,'Nov'],
		[12,'Dec']
	];
	
	for($i = 0; $i < 12; $i++){
		$num = $months[$i][0];
		$name = $months[$i][1];
		
		$sel = ($num == $selected) ? 'selected' : ''; 
		echo "<option value=$num $sel >$name</option>";
	}
	
	
	
	
	
		
		
}


function getDayOptions($selected = ''){
	
	$days =[
		 'Jan' => 31,
		 'Feb' => 28,
		 'Mar' => 31,
		 'Apr' => 30,
		 'May' => 31,
		 'Jun' => 30,
		 'Jul' => 31,
		 'Aug' => 31,
		 'Sep' => 30,
		 'Oct' => 31,
		 'Nov' => 30,
		 'Dec' => 31
	];
	
	echo "<option value=''> Day </option>";
	for($i = 1; $i <= 31; $i++){
		
	$sel = ($i == $selected) ? 'selected' : ''; 
	echo "<option value='$i' $sel >$i</option>";
	}
	
}


function getYearOptions($selected = '',$years_to_add){
	 
	echo "<option value=''> Year </option>";
	
   	$year = date("Y");
	$maxYear = date("Y") + $years_to_add;
	for($i = $year; $i <= $maxYear; $i++){
		$sel = ($i == $selected) ? 'selected' : ''; 
		echo "<option value='$i' $sel >$i</option>";
	}
	
	
	
	
}

function getHourOptions($selected = ''){
	
	echo "<option value=''>Hour</option>";
	
	for($i = 8; $i <= 17; $i++){
		
		$hour = $i;
			
		if($i <= 12){
			$sel = ($hour == $selected) ? 'selected' : '';
			echo "<option value='$hour' $sel >$hour</option>";
		}
		else{
		$hour = $hour - 12;
			$sel = ($hour == $selected) ? 'selected' : '';
			echo "<option value='$hour' $sel >$hour</option>";
		}
		
		
	}
	
}


function getMinuteOptions($selected = ''){
	
		echo "<option value=''>Minute</option>";
	
		$sel = ($selected == 1) ? 'selected' : '';
		//do not forget to -1 from value when adding to DB
		echo "<option value='1' $sel>00</option>";
		
		for($i = 15; $i < 60; $i+=15){
		$sel = ($i == $selected) ? 'selected' : '';
		echo "<option value='$i' $sel>$i</option>";
	}
		
}

function getMeridiemOptions($selected = ''){
	
	
	echo "<option value=''>AM/PM</option>";
	
	$sel = ($selected == 'am') ? 'selected' : '';
	echo "<option value='am' $sel>AM</option>";
	
	$sel = ($selected == 'pm') ? 'selected' : '';
	echo "<option value='pm' $sel >PM</option>";
}


function getNeededOptions($selected = ''){
	
	for($i = 1; $i <= 8; $i++){
		echo "<option value='$i'>$i</option>";
	}
	
}


function showServicesOptions($selected = ''){
	
echo "<option value=''>Services</option>";

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
				$sel = ($selected == $service) ? 'selected' : '';
				echo "<option value ='$service' $sel>$name</option>";
			}
		}

		db_disconnect( $dbc );

}



?>

















