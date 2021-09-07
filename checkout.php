<?php include("header.php")?>

<div class="main">
    <div class="content-area">
        <div class="heading"><h1>Checkout</h1></div>
        <div class="col-double">
            <div class="col-left">
                <?php include("./forms/checkout_form.php")?>
            </div>  
            <div class="col-right">
			 <div class="order-summary">
               <h3>Order Summary</h3>
				
<?php			if(isset($_POST['cart_checkout'])){
				
					
				$cart_id = 'cart'.$_SESSION['active_user']['user_id'];
				$cart = $_SESSION[$cart_id];
				
				
				foreach($cart as $list){
					
					
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
					$sub_total  +=($line_sub['raw']);
					$image_src  ="src='./uploads/$image' alt='service'";
					
					
					echo"
						<div class=\"line\"></div>
						<div class=\"summary-block\">
							<img $image_src />
							<div class=\"summary-block-description\"><p>$overview</p></div>
							<div class=\"summary-block-price\"><p>$subf</p></div>
						</div>";
					
						
				}//end of forloop
	
						$st ='$'.number_format($sub_total, 2,".",",");
						$tx  = '$'.number_format($sub_total * $tax, 2,".",",");
						$tl = '$'.number_format($sub_total + ($sub_total * $tax), 2,".",",");
	
					echo"
					<div class=\"line\"></div>
					<div class=\"summary-total\">
						<table>
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
					<div class=\"line\"></div>";
	
	
			}//end of post check
					
?>
				</div>	<!--end of order summary--> 
            </div>	<!--end of col left--> 
        </div>	<!--end of col double--> 
    </div>	<!--end of content area--> 
</div>	<!--end of main--> 



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
       