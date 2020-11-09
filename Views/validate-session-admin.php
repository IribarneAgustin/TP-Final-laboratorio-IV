<?php            
            if(isset($_SESSION["user"])){
                if($_SESSION["user"]->getRole()=="admin"){
                }else{
                    echo "<script> alert('You need to be logged as admin to access this page');";  
                    echo "window.location = '../index.php'; </script>";
                }
            }else{
                echo "<script> alert('You need to be logged as admin to access this page');";  
                echo "window.location = '../index.php'; </script>";
            }
?>