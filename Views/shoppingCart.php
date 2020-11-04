<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">SHOPING CART</h2>
            <form action="<?php echo FRONT_ROOT ?>Ticket/validateCard" method="post" class="bg-light-alpha">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 15%;">Movie</th>
                            <th style="width: 15%;">Time</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 15%;">Quantity</th>
                            <th style="width: 10%;">Total</th>
                            <th style="width: 10%;">Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ticketToPayList as $value) { ?>
                            <?php  ?>
                                <tr>
                                    <td> <?php echo $value->getMovieShow()->getMovie()->getTitle(); ?> </td>
                                    <td> <?php echo $value->getMovieShow()->getTime(); ?> </td>
                                    <td> <?php echo $value->getMovieShow()->getDate(); ?> </td>
                                    <td> <?php echo $value->getQuantity(); ?> </td>
                                    <td> <?php echo $value->getTotal(); ?> </td>
                                    <td>
                                        <button type="submit" name="pay" class="btn btn-danger" value="<?php echo $value->getId(); ?>"> Pay! </button>
                                    </td>
                                </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </form>
            
            <?php
                    if (isset($message) && $message != "") {
                        echo "<div class='alert alert-primary' role='alert'> $message </div>";
                    }
                    ?>
        </div>
    </section>
</main>