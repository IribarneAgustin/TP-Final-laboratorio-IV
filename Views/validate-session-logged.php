  
<?php
if (!isset($_SESSION["user"])) {
    echo "<script> alert('You need to be logged to access this page');";
    echo "window.location = '../index.php'; </script>";
}
?>