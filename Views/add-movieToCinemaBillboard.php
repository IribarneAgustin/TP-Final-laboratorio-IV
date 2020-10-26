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
                                <option value="<?php echo $value->getId() ?>" required><?php echo $value->getName(); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-dark" value="genreId">Filter</button>
                    </div>
                </div>
            </form>
            <form action="<?php echo FRONT_ROOT ?>Billboard/add" method="get" class="bg-light-alpha">
                <br>
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 10%;">Image</th>
                            <th style="width: 15%;">Title</th>
                            <th style="width: 10%;">Genre</th>
                            <th style="width: 15%;">Release Date</th>
                            <th style="width: 10%;">Language</th>
                            <th style="width: 30%;">Overview</th>
                            <th style="width: 50%;">Bilboard</th>
                            <th style="width: 10%;">Add</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($moviesList as $value) { ?>
                            <tr>
                                <?php $id = $value->getId(); ?>
                                
                                <td> <?php echo '<img src="https://image.tmdb.org/t/p/w220_and_h330_face/' . $value->getImg() . '">' ?> </td>
                                <td> <?php echo $value->getTitle(); ?> </td>
                                <td> <?php echo $value->getGenresName(); ?> </td>
                                <td> <?php echo $value->getReleaseDate(); ?> </td>
                                <td> <?php echo $value->getLanguage(); ?> </td>
                                <td> <?php echo $value->getOverview(); ?> </td>
                                <td>
                                    <div class="col">
                                        <select name="cinemaId"  class="form-control" style="width: 100%;"placeholder="Select Cinema">
                                            <?php foreach ($cinemaList as $cinema) { ?>
                                                <?php $cinemaId = $cinema->getId(); ?>
                                                <option name="cinemaId" value="<?php echo $cinemaId ?>" required><?php echo $cinema->getName(); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" name = movieId value="<?php echo $id; ?>" class="btn btn-success btn-lg"></button>
                                    <button  type="submit" class="btn btn-success btn-lg">Add to Cinema Billboard</button>
                                </td>

                            <?php } ?>

                    </tbody>
                </table>
            </form>
        </div>
        <div class="clear"></div>
</main>
</div>

<?php
include('footer.php');
?>