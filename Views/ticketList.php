<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="section1" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">User Info</h2>
            <div class="bg-dark-alpha p-3">
                <h6 class="mb-4" style="color:white">Username: <?php echo $_SESSION['user']->getUsername();?>
                </h6>
                <h6 class="mb-4" style="color:white">E-mail: <?php echo $_SESSION['user']->getEmail();?></h6>
            </div>
            <br>
            <h3 class="mb-4" style="color:white">Ticket List</h3>
            <a class="btn btn-dark" href="<?php echo FRONT_ROOT; ?>Ticket/showOrderedList/ms.date">Order by
                Date</a>
            <a class="btn btn-dark" href="<?php echo FRONT_ROOT; ?>Ticket/showOrderedList/movie.title">Order by
                Movie</a>
            <br>
            <br>
            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 20%;">Ticket Number</th>
                        <th style="width: 20%;">Movie</th>
                        <th style="width: 20%;">Time</th>
                        <th style="width: 20%;">Date</th>
                        <th style="width: 20%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ticketList as $value) { ?>
                    <?php if ($value->getStatus() == true) { ?>
                    <tr>
                        <td> <?php echo $value->getId(); ?> </td>
                        <td> <?php echo $value->getMovieShow()->getMovie()->getTitle(); ?> </td>
                        <td> <?php echo $value->getMovieShow()->getTime(); ?> </td>
                        <td> <?php echo $value->getMovieShow()->getDate(); ?> </td>
                        <td> <?php echo $value->getTotal()?> </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
            <?php 
               if(isset($message) && $message != "") {echo "<div class='alert alert-primary' role='alert'> $message </div>";}
               ?>
        </div>
    </section>
</main>