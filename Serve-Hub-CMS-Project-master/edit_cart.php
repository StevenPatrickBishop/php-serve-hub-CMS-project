<?php include("header.php") ?>
<?php error_reporting(E_ALL); ini_set('display_errors',1); ?>
<?php include "../DB/database.php";?>

<?php

if(isset($_POST['cart_item'])){

	
	$cart_id = 'cart'.$_SESSION['active_user']['user_id'];

	$cart = $_SESSION[$cart_id];

			foreach( $cart AS $list){
				$item = $list['req'];
				
				if($item == $_POST['cart_item']){
					
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
					$image_src  ="src='./uploads/$image' alt='service'";
					
				}
						
			}
	
}

?>



<div class="main">
	<div class="content-area edit-cart">
		<div class="col-single">
			<div class="edit-cart heading-row">
				<h1>Remove cart item?</h1>
			</div>

			<div class="line"></div>

<div class="cart product-row">
	<div class="pr-left">
		<img <?php echo $image_src ?> />
	</div>
	<div class="pr-right">
		<div class="pr-row-top">

			<ul>
				<li><h4>Service Date</h4></li>
				<li><p><?php echo $date ?></p></li>
			</ul>

			<ul>
				<li><h4>Start Time</h4></li>
				<li><p><?php echo $time ?></p></li>
			</ul>

			<ul>
				<li><h4>Hours Scheduled</h4></li>
				<li><p><?php echo $hours?> Hours</p></li>
			</ul>


			<ul>
				<li><h4>Hourly Rate</h4></li>
				<li><p><?php echo "$".number_format($rate,2,".",",") ?></p></li>
			</ul>

			<ul>
				<li><h4>Price</h4></li>
				<li><p><?php echo $line_sub ?></p></li>
			</ul>
		</div>
		<div class="pr-row-middle">
			<p><?php echo $overview?></p>
		</div>
		<div class="pr-row-bottom">
			<form action="./util/delete_cart_item.php" method="post">
				<input type='hidden' name ='cart_item' value='<?php echo $req ?>'>
				<input type='submit' name='remove_cart_item' value='Remove'/>
			</form>
			<a href="./shopping_cart.php">Back to cart</a>
		</div>
	</div>
</div>

<div class="line"></div>
		
				</div>
			</div>
		</div>

<?php /****************************************************************************************************************
													page functions
***********************************************************************************************************************/


function calculatelineSub($rate,$hours){
	
	return "$".number_format($rate * $hours, 2,".",",");
}



?>



		<?php include("social.php")?>
		<?php include("footer.php")?>