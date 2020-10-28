<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Movie List</h2>
            <form action="<?php echo FRONT_ROOT ?>Billboard/showFilteredList" method="get" class="bg-light-alpha">
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
        </div>
        <div class="container">
            <br>
            <form action="<?php echo FRONT_ROOT ?>Billboard/addView" method="get" class="bg-light-alpha">
                <div class="row row-cols-1 row-cols-md-4">
                    <?php foreach ($moviesList as $value) { ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?php echo $value->getId(); ?>" id="defaultCheck1">
                            <div class="col-lg-4 d-flex align-items-stretch">
                                <div class="card">
                                    <img src="https://image.tmdb.org/t/p/w220_and_h330_face/<?php echo $value->getImg() ?>" class="card-img-top">
                                    <div class="card-body">
                                        <?php $id = $value->getId(); ?>
                                        <h5 class="card-title"> <?php echo $value->getTitle(); ?></h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Genres</h6>
                                        <p class="card-text"><?php echo $value->getGenresName(); ?></p>
                                        <h6 class="card-subtitle mb-2 text-muted">Release Date</h6>
                                        <p class="card-text"><?php echo $value->getReleaseDate(); ?> </p>
                                        <h6 class="card-subtitle mb-2 text-muted">Language</h6>
                                        <p class="card-text"><?php echo $value->getLanguage(); ?></p>
                                        <h6 class="card-subtitle mb-2 text-muted">Overview</h6>
                                        <p class="card-text"><?php echo $value->getOverview(); ?></p>
                                    </div>
                    <?php } ?>
                                <div class="card-footer">
                                    <select name="cinemaId" class="form-control" style="width: 100%;" placeholder="Select Cinema">
                                        <?php foreach ($cinemaList as $cinema) { ?>
                                            <?php $cinemaId = $cinema->getId(); ?>
                                            <option name="cinemaId" value="<?php echo $cinemaId ?>" required>
                                                <?php echo $cinema->getName(); ?></option>
                                        <?php } ?>
                                    </select>

                                    <br>
                                    <button type="submit" class="btn btn-success">Add to Cinema Billboard</button>
                                </div>
                                </div>
                            </div>

                        </div>
            </form>
        </div>
</main>

<?php include('footer.php') ?>