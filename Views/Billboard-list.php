<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Billboard</h2>
            <form class="form-inline" action="<?php echo FRONT_ROOT ?>Billboard/showFilteredList" method="get">
                <div class="col">
                    <input type="date" name="date" value="" class="form-control">

                    <select name="genre" id="genreId" class="form-control" placeholder="Select genre">
                        <option selected="true" disable="disabled" value="">All genres</option>
                        <?php foreach ($genresList as $value) { ?>
                            <option value="<?php echo $value->getId() ?>" required><?php echo $value->getName(); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="btn btn-dark">Filter</button>
                </div>
            </form>
            <br>
            <?php foreach ($moviesList as $movie) { ?>
                <?php if ($this->existMovieInActiveShow($movie) == true) { ?>
                    <table class="table table-striped table-dark">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 20%;"></th>
                                <th style="width: 25%;">Movie</th>
                                <th style="width: 35%;">Overview</th>
                                <th style="width: 10%;">Language</th>
                                <th style="width: 15%;">Runtime</th>
                                <th style="width: 10%;">Genres</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <?php echo '<img src="https://image.tmdb.org/t/p/w220_and_h330_face/' . $movie->getImg() . '">' ?>
                                </td>
                                <td> <?php echo $movie->getTitle(); ?> </td>
                                <td> <?php echo $movie->getOverview(); ?> </td>
                                <td> <?php echo $movie->getLanguage(); ?> </td>
                                <td> <?php echo $movie->getRuntime() . " minutes" ?> </td>
                                <?php $genres = $this->getGenresByMovieId($movie->getId()); ?>
                                <td><?php foreach ($genres as $value) {
                                        echo $value->getName() . " ";
                                    }
                                    ?></td>
                        </tbody>

                    <?php } ?>

                    <form action="<?php echo FRONT_ROOT ?>Ticket/buyTicketView" method="post">
                        <?php foreach ($movieShowList as $show) { ?>
                            <?php if ($movie->getId() == $show->getMovie()->getId() && $show->getStatus() == true) { //&& $show->getDate() >= date('Y-m-d')) { 
                            ?>
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 10%;">Cinema</th>
                                        <th style="width: 10%;">Room</th>
                                        <th style="width: 15%;">Date</th>
                                        <th style="width: 15%;">Time</th>
                                        <th style="width: 10%;">Price</th>
                                        <th style="width: 10%;">Buy</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> <?php echo $show->getRoom()->getCinema()->getName(); //$this->cinemaDAO->getCinemaByRoomId($show->getRoom()->getId())->getName(); 
                                                ?>
                                        </td>
                                        <td> <?php echo $show->getRoom()->getName(); ?> </td>
                                        <td> <?php echo $show->getDate();  ?> </td>
                                        <td> <?php echo $show->getTime();  ?> </td>
                                        <td> <?php echo $show->getRoom()->getPrice();  ?> </td>
                                        <?php if ($show->getTicketsSold() < $show->getRoom()->getCapacity() && $show->getDate() >= date('Y-m-d')) { ?>
                                            <td> <button type="submit" class="btn btn-warning" name="movieShowId" value="<?php echo $show->getId(); ?>">BUY TICKET</button> </td>
                                        <?php } else { ?>
                                            <td> TICKETS SOLD </td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            <?php } ?>
                        <?php } ?>
                    </table>
                    <br>
                <?php } ?>
                </form>

                <?php
                if (isset($message) && $message != "") {
                    echo "<div class='alert alert-primary' role='alert'> $message </div>";
                }
                ?>
        </div>
    </section>
</main>