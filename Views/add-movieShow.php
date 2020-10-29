<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <div class="container">
        <h2 class="mb-4" style="color:white">Add MovieShow</h2>
        <div class="form-group">
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th style="width: 10%;">Image</th>
                        <th style="width: 15%;">Title</th>
                        <th style="width: 10%;">Genre</th>
                        <th style="width: 15%;">Release Date</th>
                        <th style="width: 10%;">Language</th>
                        <th style="width: 50%;">Overview</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> <?php echo '<img src="https://image.tmdb.org/t/p/w220_and_h330_face/' . $movie->getImg() . '">' ?>
                        </td>
                        <td> <?php echo $movie->getTitle(); ?> </td>
                        <td> <?php echo $movie->getGenresName(); ?> </td>
                        <td> <?php echo $movie->getReleaseDate(); ?> </td>
                        <td> <?php echo $movie->getLanguage(); ?> </td>
                        <td> <?php echo $movie->getOverview(); ?> </td>
                </tbody>
            </table>
        </div>
        <form action="<?php echo FRONT_ROOT ?>MovieShow/add" method="get" class="form-group">

            <input type="hidden" value="<?php echo $movie->getId(); ?>" name="movieId" size="30" class="form-control" required>

            <div class="bg-dark-alpha p-3">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="roomId" style="color:white">Room</label>
                        <select name="roomId" class="form-control" style="width: 100%;" placeholder="Select Room">
                            <?php foreach ($roomList as $room) { ?>
                                <?php $roomId = $room->getId(); ?>
                                <option name="roomId" value="<?php echo $roomId ?>" required>
                                    <?php echo $room->getName(); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="date" style="color:white">Date</label>
                        <input name="date" class="form-control" type="date" id="date" value="" required>
                    </div>
                    <div class="col-lg-3">
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