<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Room List</h2>
            <a class="btn btn-success" href="<?php echo FRONT_ROOT; ?>Room/showAddView/<?php echo $cinemaId ?>">Add a
                Room</a>

            <form action="<?php echo FRONT_ROOT ?>Room/remove" method="post">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 20%;">Id</th>
                            <th style="width: 20%;">Name</th>
                            <th style="width: 20%;">Capacity</th>
                            <th style="width: 20%;">Price</th>
                            <th style="width: 10%;"></th>
                            <th style="width: 10%;"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roomList as $value) { ?>
                            <?php if ($value->getStatus() == true) { ?>
                                <tr>
                                    <td> <?php echo $value->getId(); ?> </td>
                                    <td> <?php echo $value->getName(); ?> </td>
                                    <td> <?php echo $value->getCapacity(); ?> </td>
                                    <td> <?php echo $value->getPrice(); ?> </td>
                                    <td>
                                        <a class="btn btn-warning btn-block" href="<?php echo FRONT_ROOT; ?>Room/showModifyView/<?php echo $value->getId(); ?>">Modify</a>
                                    </td>
                                    <td>
                                        <button type="submit" name="remove" class="btn btn-danger btn-block" value="<?php echo $value->getId(); ?>"> Remove </button>

                                    </td>

                                </tr>
                            <?php } ?>

                        <?php } ?>

                    </tbody>

                </table>

            </form>
            <h2 class="mb-4" style="color:white">Inactive rooms List</h2>
            <form action="<?php echo FRONT_ROOT ?>Room/activate" method="post" class="bg-light-alpha">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 15%;">Id</th>
                            <th style="width: 15%;">Name</th>
                            <th style="width: 15%;">Capacity</th>
                            <th style="width: 15%;">Price</th>
                            <th style="width: 10%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roomList as $value) { ?>
                            <?php if ($value->getStatus() == false) { ?>
                                <tr>
                                    <td> <?php echo $value->getId(); ?> </td>
                                    <td> <?php echo $value->getName(); ?> </td>
                                    <td> <?php echo $value->getCapacity(); ?> </td>
                                    <td> <?php echo $value->getPrice(); ?> </td>
                                    <td>
                                        <button type="submit" name="remove" class="btn btn-warning btn-block" value="<?php echo $value->getId(); ?>">Activate</button>
                                    </td>
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
        </div>
        <!-- / main body -->
        <div class="clear"></div>
</main>
</div>
<?php
include('footer.php');
?>