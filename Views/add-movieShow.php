<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <h2 class="mb-4" style="color:white">Add MovieShow</h2>
    <div class="d-flex justify-content-center align-items-center container">
        <div class="form-group">
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th style="width: 10%;">Image</th>
                        <th style="width: 15%;">Title</th>
                        <th style="width: 15%;">Release Date</th>
                        <th style="width: 10%;">Language</th>
                        <th style="width: 50%;">Overview</th>
                        <th style="width: 50%;">Runtime</th>
                        <th style="width: 10%;">Genres</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> <?php echo '<img src="https://image.tmdb.org/t/p/w220_and_h330_face/' . $movie->getImg() . '">' ?>
                        </td>
                        <td> <?php echo $movie->getTitle(); ?> </td>
                        <td> <?php echo $movie->getReleaseDate(); ?> </td>
                        <td> <?php echo $movie->getLanguage(); ?> </td>
                        <td> <?php echo $movie->getOverview(); ?> </td>
                        <td> <?php echo $movie->getRuntime()." minutes"; ?> </td>
                        <?php $genres = $this->getGenresByMovieId($movie->getId()); ?>
                            <td><?php foreach ($genres as $value) {
                                    echo $value->getName() . " ";
                                }
                                ?></td>
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center container">
        <form action="<?php echo FRONT_ROOT ?>MovieShow/add" method="get" class="form-group">

            <input type="hidden" value="<?php echo $movie->getId(); ?>" name="movieId" size="30" class="form-control"
                required>

            <div class="bg-dark-alpha p-3">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col">
                        <label for="roomId" style="color:white">Room</label>
                        <select name="roomId" class="form-control" style="width: 100%;" placeholder="Select Room">
                            <?php foreach ($roomList as $room) { ?>
                            
                            <option name="roomId" value="<?php echo $room->getId(); ?>" required>
                                <?php echo $room->getName(); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="date" style="color:white">Date</label>
                        <input name="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" type="date" id="date"
                            value="" required>
                    </div>
                    <div class="col">
                        <label for="time" style="color:white">Time</label>
                        <input name="time" class="form-control" type="time" id="time" required>

                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-dark btn-block">Add to billboard</button>
        </form>

        <?php
        if (isset($message) && $message != "") {
            echo "<div class='alert alert-primary' role='alert'> $message </div>";
        }
        ?>


    </div>

</main>

<?php include('footer.php') ?>