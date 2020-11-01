<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
  <section id="listado" class="mb-5">
    <div class="container">
      <h2 class="mb-4" style="color:white">Cinema List</h2>
      <form action="<?php echo FRONT_ROOT ?>Cinema/remove" method="post" class="bg-light-alpha">
        <table class="table table-striped table-dark">
          <thead class="thead-dark">
            <tr>
              <th style="width: 16%;">Id</th>
              <th style="width: 16%;">Name</th>
              <th style="width: 16%;">Address</th>
              <th colspan="2" class="text-center" style="width: 16%;">Rooms</th>
              <th style="width: 16%;">Delete</th>
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
                      <a class="btn btn-success" href="<?php echo FRONT_ROOT; ?>Room/showAddView/<?php echo $value->getId(); ?>">Add</a>
                    </li>
                  </td>
                  <td>
                    <li class="list-group">
                      <a class="btn btn-primary" href="<?php echo FRONT_ROOT; ?>Room/showListByCinemaId/<?php echo $value->getId(); ?>">List</a>
                    </li>
                  </td>
                  <td>
                    <button type="submit" name="remove" class="btn btn-danger" value="<?php echo $value->getId(); ?>"> Remove </button>
                  </td>
                </tr>

              <?php } ?>
            <?php } ?>

          </tbody>
        </table>
      </form>
      <h2 class="mb-4" style="color:white">Modify</h2>
      <form action="<?php echo FRONT_ROOT . "Cinema/modify" ?>" class="bg-dark-alpha p-3">
        <div class="form-row">
          <div class="col">
            <input type="number" name="id" min=0 class="form-control" placeholder="ID">
          </div>
          <div class="col">
            <select name="field" class="form-control" placeholder="field">
              <option value="name">Name</option>
              <option value="address">Address</option>
            </select>
          </div>
          <div class="col">
            <input type="" name=newValue class="form-control" placeholder="New value">
          </div>
          <div class="col">
            <button type="submit" name="modify" class="btn btn-danger" value=""> Modify</button>
          </div>
        </div>
      </form>
      <form action="<?php echo FRONT_ROOT ?>Cinema/activate" method="post" class="bg-light-alpha">
        <table class="table table-striped table-dark">
          <thead class="thead-dark">
            <tr>
              <th style="width: 16%;">Id</th>
              <th style="width: 16%;">Name</th>
              <th style="width: 16%;">Address</th>
              <th class="text-center" style="width: 16%;">Rooms</th>
              <th style="width: 16%;">Activate</th>
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
                    <li class="list-group">
                      <a class="btn btn-primary" href="<?php echo FRONT_ROOT; ?>Room/showListByCinemaId/<?php echo $value->getId(); ?>">List</a>
                    </li>
                  </td>
                  <td>
                    <button type="submit" name="Activate" class="btn btn-warning" value="<?php echo $value->getId(); ?>"> Activate </button>
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