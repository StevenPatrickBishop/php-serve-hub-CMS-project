<?php include("header.php"); ?>
<?php include "../DB/database.php";?>

<?php

$query = "
		SELECT * FROM templates
		WHERE template_id = 2;
";

	$dbc = db_connect();

	$b_value = '';

	//get query results
		if ( $page_body = mysqli_query( $dbc, $query ) ) {
			while ( $record = mysqli_fetch_array( $page_body ) ) {
				$b_value = $record['template_body'];
			}
		}

	db_disconnect($dbc);
	
?>

<!-- Main Content section Start       -->
       
 <div class="main">
     
        <?php echo $b_value ?>
      
     
   <?php include("social.php"); ?>
</div>
       
<!-- Footer section Start       -->
     <?php include("footer.php"); ?>
      

       
       