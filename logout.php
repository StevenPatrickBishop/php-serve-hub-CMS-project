<?php include 'header.php'?>
<div class='main'>
 
        

        <?php 
            
            $_SESSION = [];
            session_destroy();
            ob_end_clean();
            header("location: index.php");
            exit();
             
        ?>
</div>
<?php include 'footer.php'?>
   


 
