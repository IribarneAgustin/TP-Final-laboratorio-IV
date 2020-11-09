<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Shopping Cart</h2>
            <form action="<?php echo FRONT_ROOT ?>Ticket/removeShoppingCart" method="post" class="bg-dark-alpha p-3">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 15%;">Movie</th>
                            <th style="width: 15%;">Time</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 10%;">Total</th>
                            <th style="width: 10%;">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ticketList as $value) { ?>
                        <?php  ?>
                        <tr>
                            <td> <?php echo $value->getMovieShow()->getMovie()->getTitle(); ?> </td>
                            <td> <?php echo $value->getMovieShow()->getTime(); ?> </td>
                            <td> <?php echo $value->getMovieShow()->getDate(); ?> </td>
                            <td> <?php echo $value->getTotal(); ?> </td>
                            <td><button type="submit" name="Delete"
                                    value="<?php echo $value->getMovieShow()->getId(); ?>" class="btn btn-danger">
                                    Remove </button></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <li class="list-group">
                    <?php if($ticketList){ ?>
                    <a class="btn btn-warning" href="<?php echo FRONT_ROOT; ?>Ticket/validationCardView">
                        Pay!</a>
                    <?php } ?>
                </li>
                <br>

                <?php
            if (isset($message) && $message != "") {
                echo "<div class='alert alert-primary' role='alert'> $message </div>";
            }
            ?>
            </form>

        </div>
    </section>
</main>