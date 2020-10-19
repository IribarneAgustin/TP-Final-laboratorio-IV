<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Movie List</h2>
            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 10%;">Imagen</th>
                        <th style="width: 15%;">Title</th>
                        <th style="width: 10%;">Genre</th>
                        <th style="width: 15%;">Release Date</th>
                        <th style="width: 10%;">Language</th>
                        <th style="width: 50%;">Overview</th>
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

                        <?php } ?>

                </tbody>
            </table>
        </div>
        <div class="clear"></div>
</main>
</div>

<?php
include('footer.php');
?>