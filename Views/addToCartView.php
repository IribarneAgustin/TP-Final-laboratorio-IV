<?php
include_once('header.php');
include_once('nav-bar.php');

?>

<main class="py-4">
    <div class="container py-5 " style="width: 20rem;">
        <div class="card bg-dark" style="width: 20rem;">
            <img src="<?php echo FRONT_ROOT ?>Assets/img/home.png" class="card-img-top" alt="..." />
            <div class="card-body">
                <h5 class="card-title" style="color:white;text-align:center">Ticket to
                    <?php echo $movieShow->getMovie()->getTitle(); ?></h5>
                <p class="card-text" style="color:white;text-align:center">Total $<?php 
                                            echo $total;
                                         ?> </p>
                <p class="card-text" style="color:white;text-align:center">Seats <?php echo $purchase->getQuantity(); ?>
                </p>
                <div class="col text-center">
                    <a href="<?php echo FRONT_ROOT ?>Ticket/addToCart/1" class="btn btn-warning">Add to cart</a>
                </div>
                <br>
                <div class="col text-center">
                    <a href="<?php echo FRONT_ROOT ?>Ticket/addToCart/" class="btn btn-warning">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</main>