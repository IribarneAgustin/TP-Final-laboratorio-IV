<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-5">
  <section id="listado" class="mb-5">
    <div class="container">
      <form action="<?php echo FRONT_ROOT ?>Cinema/remove" method="post">
        <h2 class="mb-4">Cinema List</h2>
        <table class="table bg-light-alpha">
          <thead>
            <tr>
              <th style="width: 15%;">Id</th>
              <th style="width: 15%;">Name</th>
              <th style="width: 30%;">Adress</th>
              <th style="width: 30%;">Ticket Price</th>
              <th style="width: 15%;">Capacity</th>
              <th style="width: 10%;">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cinemaList as $value) { ?>
              <tr>
                <td> <?php echo $value->getId(); ?> </td>
                <td> <?php echo $value->getName(); ?> </td>
                <td> <?php echo $value->getAdress(); ?> </td>
                <td> <?php echo $value->getTicketPrice(); ?> </td>
                <td> <?php echo $value->getCapacity(); ?> </td>
                <td>
                  <button type="submit" name="remove" class="btn btn-danger" value="<?php echo $value->getId(); ?>"> Remove </button>
                </td>
              </tr>

            <?php } ?>

          </tbody>
        </table>
      </form>
      <form action="<?php echo FRONT_ROOT . "Cinema/modify" ?>" >
        <h2 class="mb-4">Modify</h2>
        <table class="table bg-light-alpha">
          <thead>
            <tr>
              <th style="width: 35%;">Id</th>
              <th style="width: 25%;">Field to modify</th>
              <th style="width: 25%;">New value</th>
              <th style="width: 25%;">Modify</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <input type="number" name="id" min=0 required>
              </td>
              <td>
                <select name="field" widht="150px" required>
                  <option value="name">Name</option>
                  <option value="adress">Adress</option>
                  <option value="ticketPrice">Ticket Price</option>
                  <option value="capacity">Capacity</option>
                </select>
              </td>
              <td>
                <input type="" name="newValue" required>
              </td>
              <td>
                <button type="submit" name="modify" class="btn btn-danger" value=""> Modify</button>
              </td>
            </tr>
          </tbody>

      </form>
    </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
</main>
</div>

<?php echo $message; ?>

<?php
include('footer.php');
?>