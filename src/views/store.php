<?php  
    if (isset($_POST["submit"])) { 
        echo "<div> POST BODY <br>"; 
        print_r($_POST); 
        echo "</div>"; 
    } 
?>