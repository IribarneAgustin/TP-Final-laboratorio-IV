<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Movie Show Admin</h2>
            <form action="<?php echo FRONT_ROOT ?>MovieShow/remove" method="post" class="bg-light-alpha">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>

                            <th style="width: 15%;">Id</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 15%;">Time</th>
                            <th style="width: 15%;">Tickets Sold</th>
                            <th style="width: 10%;">Room</th>
                            <th style="width: 10%;">Cinema</th>
                            <th style="width: 10%;">Movie</th>
                            <th style="width: 10%;">Img</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movieShowList as $value) { ?>
                            <?php if ($value->getStatus() == true) { ?>
                                <tr>

                                    <td> <?php echo $value->getId(); ?> </td>
                                    <td> <?php echo $value->getDate(); ?> </td>
                                    <td> <?php echo $value->getTime(); ?> </td>
                                    <td> <?php echo $value->getTicketsSold(); ?> </td>
                                    <td> <?php echo $value->getRoom()->getName(); ?> </td>
                                    <td> <?php echo $value->getRoom()->getCinema()->getName(); //$this->cinemasDAO->getCinemaByRoomId($value->getRoom()->getId())->getName(); 
                                            ?> </td>
                                    <td> <?php echo $value->getMovie()->getTitle(); ?> </td>
                                    <td> <?php echo '<img src="https://image.tmdb.org/t/p/w220_and_h330_face/' . $value->getMovie()->getImg() . '">' ?> </td>
                                    <td>
                                        <button type="submit" name="remove" class="btn btn-danger" value="<?php echo $value->getId(); ?>"> Remove </button>
                                    </td>
                                </tr>

                            <?php } ?>
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