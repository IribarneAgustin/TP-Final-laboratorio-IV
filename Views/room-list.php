<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
  <section id="listado" class="mb-5">
    <div class="container">
      <h2 class="mb-4" style="color:white">Room List</h2>
      <form action="<?php echo FRONT_ROOT ?>Room/remove" method="post" class="bg-light-alpha">
        <table class="table table-striped table-dark">
          <thead class="thead-dark">
            <tr>
              <th style="width: 15%;">Id</th>
              <th style="width: 15%;">Name</th>
              <th style="width: 15%;">Capacity</th>
              <th style="width: 15%;">Price</th>
              <th style="width: 10%;">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($roomList as $value) { ?>
              <tr>
                <td> <?php echo $value->getId(); ?> </td>
                <td> <?php echo $value->getName(); ?> </td>
                <td> <?php echo $value->getCapacity(); ?> </td>
                <td> <?php echo $value->getPrice(); ?> </td>
                <td>
                  <button type="submit" name="remove" class="btn btn-danger" value="<?php echo $value->getId(); ?>"> Remove </button>
                </td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
      </form>
      <h2 class="mb-4" style="color:white">Modify</h2>
      <form action="<?php echo FRONT_ROOT . "Room/modify" ?>" class="bg-dark-alpha p-3">
        <div class="form-row">
          <div class="col">
            <input type="number" name="id" min=0 class="form-control" placeholder="ID">
          </div>
          <div class="col">
            <select name="field" class="form-control" placeholder="field">
              <option value="Name">Name</option>
              <option value="Capacity">Capacity</option>
              <option value="Price">Price</option>
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