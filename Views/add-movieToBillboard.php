<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Add to billboard</h2>
            <tbody>
                <form action="<?php echo FRONT_ROOT ?>MovieShow/addView" method="get" class="bg-light-alpha">
                    <div class="form-group">
                        <label for="movieId">Select Movie</label>
                        <select name="movieId" class="form-control" style="width: 100%;" id="movieId" placeholder="Select Movie">
                            <?php foreach ($moviesList as $movie) { ?>
                                <option name="movieId" value="<?php echo $movie->getId(); ?>" required>
                                    <?php echo $movie->getTitle(); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cinemaId">Select Cinema</label>
                        <select name="cinemaId" class="form-control" style="width: 100%;" placeholder="Select Cinema">
                            <?php foreach ($cinemaList as $cinema) { ?>
                                <?php $cinemaId = $cinema->getId(); ?>
                                <option name="cinemaId" value="<?php echo $cinemaId ?>" required>
                                    <?php echo $cinema->getName(); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block">Add to Cinema Billboard</button>

                </form>
            </tbody>
            </table>
        </div>
        <div class="clear"></div>
</main>

</div>

<?php
include('footer.php');
?>