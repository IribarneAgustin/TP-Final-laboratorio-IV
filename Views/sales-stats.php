<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Ticket Sales Stats</h2>
            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 10%;"></th>
                        <th style="width: 10%;">Movie</th>
                        <th style="width: 10%;">Cinema&Room</th>
                        <th style="width: 10%;">Date&Time</th>
                        <th style="width: 10%;">Tickets Sold</th>
                        <th style="width: 10%;">Tickets Left</th>
                        <th style="width: 10%;">Movieshow Id</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movieShowList as $value) { ?>
                    <?php if ($value->getStatus() == true) { ?>
                    <tr>
                        <td> <?php echo '<img src="https://image.tmdb.org/t/p/w220_and_h330_face/' . $value->getMovie()->getImg() . '" width=150 height=200>' ?>
                        </td>
                        <td> <?php echo $value->getMovie()->getTitle(); ?> </td>
                        <td> <?php echo $value->getRoom()->getCinema()->getName(); ?><br>
                            <?php echo $value->getRoom()->getName(); ?> </td>
                        <td> <?php echo $value->getDate(); ?><br>
                            <?php echo $value->getTime(); ?> </td>
                        <?php $ticketsLeft= ($value->getRoom()->getCapacity()) - ($value->getTicketsSold());?>
                        <td> <?php echo $value->getTicketsSold(); ?> </td>
                        <td> <?php echo $ticketsLeft; ?></td>
                        <td> <?php echo $value->getId(); ?> </td>

                    </tr>

                    <?php } ?>
                    <?php } ?>

                </tbody>
            </table>
            <br>
            <h2 class="mb-4" style="color:white">Sales by Movie</h2>
            <h5 class="mb-4" style="color:white">(Between dates)</h5>
            <div class="bg-dark-alpha p-3">
                <form class="form-inline" action="<?php echo FRONT_ROOT ?>Ticket/showSalesByMovieBetweenDates"
                    method="post">
                    <div class="col">
                        <input type="date" name="date1" value="date1" class="form-control">
                        <input type="date" name="date2" value="date2" class="form-control">
                        <button type="submit" class="btn btn-dark">Filter</button>
                    </div>
                </form>
                <br>
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 10%;">Name</th>
                            <th style="width: 10%;">Tickets Sold</th>
                            <th style="width: 10%;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($movieList){?>
                        <?php foreach ($movieList as $row) { ?>
                        <tr>
                            <td><?php echo $row['title']?></td>
                            <td><?php echo $row['COUNT(t.id)']?></td>
                            <td><?php echo $row['SUM(t.total)']?></td>
                        </tr>
                        <?php } ?>
                        <?php }else{ ?>
                        <tr>
                            <td></td>
                            <td><?php echo "No sales between those dates"?></td>
                            <td></td>
                        <tr>
                            <?php } ?>
                    </tbody>
                </table>
                </form>
            </div>
            <br>

            <h2 class="mb-4" style="color:white">Sales by Cinema</h2>
            <h5 class="mb-4" style="color:white">(Between dates)</h5>
            <div class="bg-dark-alpha p-3">
                <form class="form-inline" action="<?php echo FRONT_ROOT ?>Ticket/showSalesByCinemaBetweenDates"
                    method="post">
                    <div class="col">
                        <input type="date" name="date1" value="date1" class="form-control">
                        <input type="date" name="date2" value="date2" class="form-control">
                        <button type="submit" class="btn btn-dark">Filter</button>
                    </div>
                </form>
                <br>

                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 10%;">Name</th>
                            <th style="width: 10%;">Tickets Sold</th>
                            <th style="width: 10%;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($cinemaList){?>
                        <?php foreach ($cinemaList as $row) { ?>
                        <tr>
                            <td><?php echo $row['name']?></td>
                            <td><?php echo $row['COUNT(t.id)']?></td>
                            <td><?php echo $row['SUM(t.total)']?></td>
                        </tr>
                        <?php } ?>
                        <?php }else{ ?>
                        <tr>
                            <td></td>
                            <td><?php echo "No sales between those dates"?></td>
                            <td></td>
                        <tr>
                            <?php } ?>
                    </tbody>
                </table>
                </form>
            </div>
            <?php
            if (isset($message) && $message != "") {
                echo "<div class='alert alert-primary' role='alert'> $message </div>";
            }
            ?>
        </div>
    </section>
</main>