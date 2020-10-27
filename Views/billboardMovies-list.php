<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
  <section id="listado" class="mb-5">
    <div class="container">
      <h2 class="mb-4">Billboard Movie List</h2>
      <form action="<?php echo FRONT_ROOT ?>Billboard/remove" method="post" class="bg-light-alpha">
        <table class="table table-striped table-dark">
          <thead class="thead-dark">
            <tr>
              <th style="width: 15%;">Id</th>
              <th style="width: 30%;">Name</th>
              <th style="width: 30%;">Status</th>
              <th style="width: 30%;">Movies</th>
              <th style="width: 30%;">Remove</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($billboardMovieList as $value) { ?>
              <tr>
                <td> <?php echo $value->getId(); ?> </td>
                <td> <?php echo $value->getName(); ?> </td>
                <td> <?php if($value->getStatus() == 1){echo "Active";} else {echo "Inactive";}; ?> </td>
                <td>
                  <li class="list-group">
                    <a class="btn btn-success" href="<?php echo FRONT_ROOT; ?>Billboard/billboardAdminView/<?php echo $value->getId();?>">List</a>
                  </li>
                </td>
                <td>
                  <button type="submit" name="remove" class="btn btn-danger" value="<?php echo $value->getId(); ?>"> Remove </button>
                </td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
    <!-- / main body -->
    <div class="clear"></div>
</main>
</div>
<?php
include('footer.php');
?>