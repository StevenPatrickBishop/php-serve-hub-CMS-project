<?php include("../header.php")?>
<?php error_reporting(E_ALL); ini_set('display_errors',1); ?>
<?php include "../../DB/database.php";?>

<?



if(isset($_POST['remove_cart_item'])){
	
	//receive post
	$req = $_POST['cart_item'];
	
	
	
	echo $req;
	
	
	
	//create delete query 

$query ="
	DELETE from requests
	WHERE request_id = '$req'
";

	//run querey 
$dbc = db_connect();
	
	mysqli_query( $dbc, $query);
	
	
db_disconnect($dbc);
	
	
	
//refresh sesson cart
$cart_id = 'cart'.$_SESSION['current_user'];
$_SESSION[$cart_id] = [];
	
	
}
//redirect to cart
	
  ob_end_clean();
  header( 'Location: ../shopping_cart.php' ) ;
  exit;
?>


















