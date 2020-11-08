<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Cinema List</h2>
            <form action="<?php echo FRONT_ROOT ?>Cinema/remove" method="post">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 16%;">Id</th>
                            <th style="width: 16%;">Name</th>
                            <th style="width: 16%;">Address</th>
                            <th colspan="2" class="text-center" style="width: 16%;">Rooms</th>
                            <th colspan="2" style="width: 16%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cinemaList as $value) { ?>
                        <?php if ($value->getStatus() == 1) { ?>
                        <tr>
                            <td> <?php echo $value->getId(); ?> </td>
                            <td> <?php echo $value->getName(); ?> </td>
                            <td> <?php echo $value->getAddress(); ?> </td>
                            <td>
                                <li class="list-group">
                                    <a class="btn btn-success"
                                        href="<?php echo FRONT_ROOT; ?>Room/showAddView/<?php echo $value->getId(); ?>">Add</a>
                                </li>
                            </td>
                            <td>
                                <li class="list-group">
                                    <a class="btn btn-primary"
                                        href="<?php echo FRONT_ROOT; ?>Room/showListByCinemaId/<?php echo $value->getId(); ?>">List</a>
                                </li>
                            </td>
                            <td>
                                <li class="list-group">
                                    <a class="btn btn-warning"
                                        href="<?php echo FRONT_ROOT; ?>Cinema/showModifyView/<?php echo $value->getId(); ?>">Modify</a>
                                </li>
                            </td>
                            <td>
                                <button type="submit" name="remove" class="btn btn-danger"
                                    value="<?php echo $value->getId(); ?>"> Remove </button>
                            </td>
                        </tr>

                        <?php } ?>
                        <?php } ?>

                    </tbody>
                </table>
            </form>
            <form action="<?php echo FRONT_ROOT ?>Cinema/activate" method="post">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 16%;">Id</th>
                            <th style="width: 16%;">Name</th>
                            <th style="width: 16%;">Address</th>
                            <th class="text-center" style="width: 16%;">Rooms</th>
                            <th style="width: 16%;"></th>
                        </tr>
                    </thead>
                    <h2 class="mb-4" style="color:white">Inactive cinemas</h2>
                    <tbody>
                        <?php foreach ($cinemaList as $value) { ?>
                        <?php if ($value->getStatus() == false) { ?>
                        <tr>
                            <td> <?php echo $value->getId(); ?> </td>
                            <td> <?php echo $value->getName(); ?> </td>
                            <td> <?php echo $value->getAddress(); ?> </td>
                            <td>
                                <a class="btn btn-primary btn-block"
                                    href="<?php echo FRONT_ROOT; ?>Room/showListByCinemaId/<?php echo $value->getId(); ?>">List</a>
                            </td>
                            <td>
                                <button type="submit" name="activate" class="btn btn-warning btn-block"
                                    value="<?php echo $value->getId(); ?>"> Activate </button>
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