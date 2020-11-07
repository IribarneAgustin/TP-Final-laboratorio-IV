<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Ticket Sales Stats</h2>
            <h4 class="mb-4" style="color:white">Tickets sold and left</h4>
            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 10%;">Movie</th>
                        <th style="width: 10%;">Cinema</th>
                        <th style="width: 10%;">Room</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 10%;">Time</th>
                        <th style="width: 10%;">Tickets Sold</th>
                        <th style="width: 10%;">Tickets Left</th>
                        <th style="width: 10%;">Id</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movieShowList as $value) { ?>
                    <?php if ($value->getStatus() == true) { ?>
                    <tr>
                        <td> <?php echo $value->getMovie()->getTitle(); ?> </td>
                        <td> <?php echo $value->getRoom()->getCinema()->getName(); ?></td>
                        <td> <?php echo $value->getRoom()->getName(); ?> </td>
                        <td> <?php echo $value->getDate(); ?> </td>
                        <td> <?php echo $value->getTime(); ?> </td>
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
            <h4 class="mb-4" style="color:white">Total earnings between dates</h4>
            <form class="form-inline" action="<?php echo FRONT_ROOT ?>Billboard/showFilteredList" method="get">
                <div class="col">
                    <select name="field" class="form-control" placeholder="field">
                        <option value="name">Movie</option>
                        <option value="address">Cinema</option>
                    </select>
                    <input type="date" name="date" value="" class="form-control">
                    <input type="date" name="date" value="" class="form-control">
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
                    <?php foreach ($movieShowList as $value) { ?>
                    <?php if ($value->getStatus() == true) { ?>
                    <tr>
                        <td>    </td>
                        <td>    </td>
                        <td>    </td>
                    </tr>

                    <?php } ?>
                    <?php } ?>

                </tbody>
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