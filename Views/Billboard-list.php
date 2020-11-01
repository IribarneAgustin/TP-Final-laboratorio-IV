<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Billboard</h2>
            <form action="<?php echo FRONT_ROOT ?>Billboard/showFilteredListByDate" method="get">
                <div class="form-row">
                    <div class="col">
                        <input type="date" name="date" value="" class="form-control">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-dark" value="genreId">Filter</button>
                    </div>
                </div>
            </form>
            <br>
            <form action="<?php echo FRONT_ROOT ?>Billboard/showFilteredListByGenre" method="get">
                <div class="form-row">
                    <div class="col">
                        <select name="genre" id="genreId" class="form-control" placeholder="Select genre">
                            <option selected="true" disable="disabled" value="">All genres</option>
                            <?php foreach ($genresList as $value) { ?>
                                <option value="<?php echo $value->getId() ?>" required><?php echo $value->getName(); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-dark" value="genreId">Filter</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-dark">
                <br>
                <?php foreach ($moviesList as $movie) { ?>

                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 15%;"></th>
                            <th style="width: 15%;">Movie</th>
                            <th style="width: 15%;">Overview</th>
                            <th style="width: 10%;">Language</th>
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
                            <?php $genres = $this->getGenresByMovieId($movie->getId()); ?>
                            <td><?php foreach ($genres as $value) {
                                    echo $value->getName() . " ";
                                }
                                ?></td>
                    </tbody>

            </table>
            <h3 style="color:white">Available Screening Rooms</h3>
            <form action="<?php echo FRONT_ROOT ?>Ticket/BuyTicket" method="post">
                <?php foreach ($movieShowList as $show) { ?>
                    <table class="table table-striped table-dark">
                        <?php if ($movie->getId() == $show->getMovie()->getId()) { ?>
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
                                    <td> <?php echo $this->cinemaDAO->getCinemaByRoomId($show->getRoom()->getId())->getName(); ?> </td>
                                    <td> <?php echo $show->getRoom()->getName(); ?> </td>
                                    <td> <?php echo $show->getDate();  ?> </td>
                                    <td> <?php echo $show->getTime();  ?> </td>
                                    <td> <?php echo $show->getRoom()->getPrice();  ?> </td>
                                    <td> <button type="submit" class="btn btn-warning" name="movieShowId" value="<?php echo $show->getId(); ?>">BUY TICKET</button>  </td>
                                <?php }  ?>
                                </tr>
                            </tbody>
                        <?php } ?>
                    <?php } ?>
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