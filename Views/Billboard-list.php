<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Billboard</h2>

            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 15%;"></th>
                        <th style="width: 15%;">Movie</th>
                        <th style="width: 15%;">Overview</th>
                        <th style="width: 10%;">Language</th>

                    </tr>
                </thead>
                <tbody>
                <br>
                    <?php foreach ($movieList as $value) { ?>
                        <tr>
                            <td> <?php echo '<img src="https://image.tmdb.org/t/p/w220_and_h330_face/' . $value->getImg() . '">' ?> </td>
                            <td> <?php echo $value->getTitle(); ?> </td>
                            <td> <?php echo $value->getOverview(); ?> </td>
                            <td> <?php echo $value->getLanguage(); ?> </td>
                        </tr>
                </tbody>

            </table>
            <h2>Availaible Functions</h2>
            <?php foreach ($movieShowList as $show) { ?>
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 10%;">Cinema</th>
                            <th style="width: 10%;">Room</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 15%;">Time</th>
                            <th style="width: 10%;">Price</th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> <?php echo $this->cinemaDAO->getById($show->getRoom()->getId())->getName(); ?> </td>
                            <td> <?php echo $show->getRoom()->getName(); ?> </td>
                            <td> <?php echo $show->getDate();  ?> </td>
                            <td> <?php echo $show->getTime();  ?> </td>
                            <td> <?php echo $show->getRoom()->getPrice();  ?> </td>
                        </tr>
                    </tbody>
                <?php } ?>

            <?php } ?>
                </table>

        </div>
    </section>
</main>