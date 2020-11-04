<?php
include_once('header.php');
include_once('nav-bar.php');

?>

<div class="container py-5 " style="width: 30rem;">

    <div class="card" style="width: 18rem;">
        <img src="<?php echo FRONT_ROOT ?>Assets/img/home.png" class="card-img-top" alt="..." />
        <div class="card-body">
            <h5 class="card-title">Ticket to <?php echo $movieShow->getMovie()->getTitle(); ?></h5>
            <p class="card-text">Total $<?php if (isset($ticket)) {
                                            echo $ticket->getTotal();
                                        } ?> </p>
            <p class="card-text">Seats <?php echo $ticket->getQuantity(); ?> </p>
            <div class="col text-center">
                <a href="<?php echo FRONT_ROOT ?>Ticket/addToCart/1" class="btn btn-primary">Add to car</a>
            </div>
            <div class="col text-center">
                <a href="<?php echo FRONT_ROOT ?>Ticket/addToCart/" class="btn btn-primary">Cancel</a>
            </div>
        </div>
    </div>
</div>