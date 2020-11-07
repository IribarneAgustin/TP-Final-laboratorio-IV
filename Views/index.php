<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Welcome to Moviepass! Log in to buy your tickets!</h2>
            <br>
            <?php foreach ($moviesList as $movie) { ?>
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 20%;"></th>
                            <th style="width: 20%;">Movie</th>
                            <th style="width: 35%;">Overview</th>
                            <th style="width: 10%;">Language</th>
                            <th style="width: 20%;">Genres</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> <?php echo '<img src="https://image.tmdb.org/t/p/w220_and_h330_face/' . $movie->getImg() . '">' ?>
                            </td>
                            <td> <?php echo $movie->getTitle(); ?> </td>
                            <td> <?php echo $movie->getOverview(); ?> </td>
                            <td> <?php echo $movie->getLanguage(); ?> </td>
                            <?php $genres = $this->getGenresByMovieId($movie->getId()); ?>
                            <td><?php foreach ($genres as $value) {
                                    echo $value->getName() . " ";
                                }
                                ?></td>
                    </tbody>
                    <?php foreach ($movieShowList as $show) { ?>
                        <?php if ($movie->getId() == $show->getMovie()->getId() && $show->getStatus() == true) { ?>
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 20%;">Cinema</th>
                                    <th style="width: 20%;">Room</th>
                                    <th style="width: 20%;">Date</th>
                                    <th style="width: 20%;">Time</th>
                                    <th style="width: 20%;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> <?php echo $this->cinemaDAO->getCinemaByRoomId($show->getRoom()->getId())->getName(); ?>
                                    </td>
                                    <td> <?php echo $show->getRoom()->getName(); ?> </td>
                                    <td> <?php echo $show->getDate();  ?> </td>
                                    <td> <?php echo $show->getTime();  ?> </td>
                                    <td> <?php echo $show->getRoom()->getPrice();  ?> </td>
                                <?php }  ?>
                                </tr>
                            </tbody>
                        <?php } ?>
                </table>
                <br>
            <?php } ?>
            <?php
            if (isset($message) && $message != "") {
                echo "<div class='alert alert-primary' role='alert'> $message </div>";
            }
            ?>
        </div>
    </section>
</main>