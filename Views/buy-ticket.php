<?php
include('header.php');
include('nav-bar.php');
?>
<main class="py-4">
    <section class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Buy ticket</h2>
            <div class="bg-dark-alpha p-3">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 10%;"></th>
                            <th style="width: 10%;">Movie</th>
                            <th style="width: 10%;">Cinema</th>
                            <th style="width: 10%;">Room</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 15%;">Time</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> <?php echo '<img src="https://image.tmdb.org/t/p/w220_and_h330_face/' . $this->movieDAO->getById($movieShow->getMovie()->getId())->getImg() . '">' ?>
                            </td>
                            <td> <?php echo $this->movieDAO->getById($movieShow->getMovie()->getId())->getTitle(); ?>
                            </td>
                            <td> <?php echo $this->cinemaDAO->getCinemaByRoomId($movieShow->getRoom()->getId())->getName(); ?>
                            </td>
                            <td> <?php echo $movieShow->getRoom()->getName(); ?> </td>
                            <td> <?php echo $movieShow->getDate();  ?> </td>
                            <td> <?php echo $movieShow->getTime(); ?> </td>

                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-center align-items-center container">
                    <form action="<?php echo FRONT_ROOT ?>Ticket/processPurchase" method="post">
                        <input type="hidden" name="movieShowId" value="<?php echo $movieShow->getId(); ?>" size="30"
                            class="form-control" required>
                        <div class="form-group">
                            <label for="" style="color:white">Quantity</label>
                            <input type="number" name="quantity" size="30" min="1" class="form-control" required>
                            <br>
                            <button type="submit" name="button" class="btn btn-warning">Generate
                                Ticket</button>
                        </div>
                </div>
            </div>
            <?php
            if (isset($message) && $message != "") {
                echo "<div class='alert alert-primary' role='alert'> $message </div>";
            }
            ?>
            </form>
            <br>
        </div>
    </section>
</main>

<?php include('footer.php') ?>