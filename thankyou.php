<?php include("header.php")?>
<?php include "../DB/database.php";?>
<div class="main main-thankyou">
<div class="content-area thankyou-content">
<div class="thankyou-background"></div>
<div class="thankyou-wrap">
<h1>Thank you for scheduling</h1>
<p>You will be hear from us soon to confirm your appointment.</p>
<p>Check out some of our other services we currently offer</p>

<?php emptyCart();?>
<a href="select_service.php"><button>Services</button></a>
</div>
</div>
</div>




<?php
function emptyCart(){

    $cart_id = 'cart'.$_SESSION['active_user']['user_id'];
	$_id = $_SESSION['active_user']['user_id'];
	$query = " DELETE FROM services WHERE user_id = '$_id'";
	$dbc = db_connect();
	mysqli_query( $dbc, $query );
    db_disconnect( $dbc );
    $_SESSION[$cart_id] = [];
	
}
?>

<?php include("social.php")?>
<?php include("footer.php")?>