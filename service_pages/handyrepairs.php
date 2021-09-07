<?php include("../header.php")?>
<?php include("../../DB/database.php"); ?>
<?php $service="176" ?>


<!-- Main Content section Start--> 
<div class="main"> 
<div class="services-content-area"> 

<?php
$dbc = db_connect();

$query = "
SELECT service_name,
service_image,
service_description,
CONCAT('$',FORMAT(service_rate,2)) Rate 
FROM services
WHERE service_id = $service;
";

//process query
if (@mysqli_query($dbc, $query)) {
} 
else {
print '<p style="color: red;"> Service not added:<br />' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
}
//load service description data
if($r = mysqli_query($dbc, $query)){
while($record = mysqli_fetch_array($r)){
$heading = $record['service_name'];
$image =$record['service_image'];
$description = $record['service_description'];
$rate = $record['Rate'];
}
}

db_disconnect($dbc);
?>

<h1><?php echo $heading; ?></h1>

<div class="service-description">
<div class="service-img"><img src='../uploads/<?php echo $image ?>' alt='service-img' /></div>

  <div class="service-text">
                  <h2>Service Description</h2>
                  <p><?php echo $description ?></p>
                  <p class="p-bold">Per hour Rate <span><?php echo $rate ?></span></p>
                  <?php include("../forms/scheduling_form.php") ?>
</div>

<a href="../select_service.php"><button>Back to services</button></a>
</div>

</div> 
</div> <!-- Main content section End --> 



<?php include("../social.php")?>
<?php include("../footer.php")?>
