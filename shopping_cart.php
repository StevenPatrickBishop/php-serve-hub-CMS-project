<?php include("header.php") ?>
<?php error_reporting(E_ALL); ini_set('display_errors',1); ?>
<?php include "../DB/database.php";?>


<?php

		//get cart items
		$query = "	SELECT s.service_image AS image,
						   s.service_name AS service,
						   s.service_id,
						   s.service_overview AS overview,
						   s.service_rate AS rate,
						   t.tax_value AS tax,
						   r.user_id AS user,
						   u.first_name AS name,
						   r.request_date AS date,
						   r.request_start AS time,
						   r.request_hours AS hours,
						   r.request_id

					FROM services s
					JOIN requests r ON r.request_service = s.service_id
					jOIN users u ON u.user_id = r.user_id
					JOIN tax t ON t.tax_id = s.service_tax_code
					WHERE r.user_id = 5
				";



				$dbc = db_connect();

		//run query
		if ( $r = mysqli_query( $dbc, $query ) ) {
			$index = 0;
			 
			$cart_id = 'cart'.$_SESSION['active_user']['user_id'];
			$_SESSION[$cart_id] = [];
			while ( $record = mysqli_fetch_array( $r ) ) {
				
				$image = $record['image'];
				$service = $record['service'];
				$serv_id = $record['service_id'];
				$overview = $record['overview'];
				$rate = $record['rate'];
				$tax = $record['tax'];
				$user = $record['user'];
				$name = $record['name'];
				$date = $record['date'];
				$time = $record['time'];
				$hours = $record['hours'];
				$req = $record['request_id'];
				
				
				//create cart item
				$cart_item = [
				"image" 	=>  $image, 
				"service" 	=>  $service,
				"serv_id" 	=>  $serv_id,
				"overview" 	=>  $overview,
				"rate" 		=>  $rate,
				"tax" 		=>  $tax,
				"user" 		=>  $user,
				"name" 		=>  $name,
				"date" 		=>  $date,
				"time" 		=>  $time,
				"hours" 	=>  $hours,
				"req" 		=>  $req,
				];
				
				//push cart to SESSION
				if(!isset($_SESSION[$cart_id])){
					$_SESSION[$cart_id] = [$cart_item];
				}
				else{
					array_push($_SESSION[$cart_id],$cart_item);
				}
				
			}//end while
		}//run query end

				db_disconnect($dbc);
?>





<!-- Main Cart section Start       -->
	
<div class="main">
    <div class="content-area shopping-cart-area">
		
		
		
		<?php 
		
		
		$cart = $_SESSION[$cart_id];?>
		
        
		
		
		
		<div class="col-single">
            <div class="cart heading-row">
                <h1>Your Cart (<?php echo count($cart); ?> items)</h1>
            </div>
			
					
<?php 
			
	if(count($cart) > 0){
		
					$sub_total = 0;
		
					foreach( $cart AS $list){

	
					$image 		= $list['image'];
					$service	= $list['service'];
					$serv_id	= $list['serv_id'];
					$overview	= $list['overview'];
					$rate		= $list['rate'];
					$tax		= $list['tax'];
					$user		= $list['user'];
					$name		= $list['name'];
					$date		= $list['date'];
					$time		= $list['time'];
					$hours		= $list['hours'];
					$req		= $list['req'];
					$line_sub	= calculatelineSub($rate,$hours);
					$subf 		= $line_sub['formatted'];
					$sub_total  += ($line_sub['raw']);
					$image_src  ="src='./uploads/$image' alt='service'";
					$ratef = '$'.number_format($rate, 2,".",",");
		
		
echo("

<div class=\"line\"></div>

<div class=\"cart product-row\">
<div class=\"pr-left\">
<img $image_src />
</div>
<div class=\"pr-right\">
<div class=\"pr-row-top\">

<ul>
<li><h4>Service Date</h4></li>
<li><p>$date</p></li>
</ul>

<ul>
<li><h4>Start Time</h4></li>
<li><p>$time</p></li>
</ul>

<ul>
<li><h4>Hours Scheduled</h4></li>
<li><p>$hours Hours</p></li>
</ul>


<ul>
<li><h4>Hourly Rate</h4></li>
<li><p>$ratef</p></li>
</ul>

<ul>
<li><h4>Price</h4></li>

<li><p>$subf</p></li>
</ul>

</div>
<div class=\"pr-row-middle\">
<p>$overview</p>
</div>
<div class=\"pr-row-bottom\">
	
	<form action='edit_cart.php' method='post'>
	<p><input type='hidden' name='cart_item' value ='$req'/></p>
	<p><input type='submit' value='Remove item'/></p>
	</form>
	
</div>
</div>
</div>

<div class=\"line\"></div>");


		
	}//end of foreach


		
?>
			
 </div>		
<div class="col-single">
	<div class="total-row">
		
		<form action="Checkout.php" method="post">
		<p><input class="button" name="cart_checkout" type="submit" value="Checkout"/></p>
		</form>
		
<?php		
				  $st ='$'.number_format($sub_total, 2,".",",");
				  $tx  = '$'.number_format($sub_total * $tax, 2,".",",");
				  $tl = '$'.number_format($sub_total + ($sub_total * $tax), 2,".",",");
		
		echo"<table>
			<tr>
				<td><h4>Sub:</h4></td>
				<td><p>$st</p></td>
			</tr>
			<tr>
				<td><h4>Tax:</h4></td>
				<td><p>$tx</p></td>
			</tr>
			<tr>
				<td><h4>Total:</h4></td>
				<td><p>$tl</p></td>
			</tr>
			</table>
		
		
	</div>
</div>
		
		";

		
	} else{
		echo"<h2>Your shopping cart is empty! Check out some of our services we currently offer</h2>
		<a href='select_service.php'><button>Services</button></a>";
	}
	
			
?>

		
		
		
    </div> <!--end content area-->
</div>    <!--end main area-->

       

<?php /****************************************************************************************************************
													page functions
***********************************************************************************************************************/


function calculatelineSub($rate,$hours){
	
	return [
		'formatted' => "$".number_format($rate * $hours, 2,".",","),
		'raw' => $rate * $hours
	]; 			
}


?>

 <?php include("social.php")?>
 <?php include("footer.php")?>