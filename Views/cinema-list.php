<?php 
include('header.php');
include('nav-bar.php');
?>

<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
            <h2 class="mb-4">Cinema List</h2>
            <form action="Cinema/showList" method="get">
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
            <?php foreach($cinemaList as $value) { ?>
            <tr>
                <td> <?php echo $value->getId(); ?> </td>
                <td> <?php echo $value->getName(); ?> </td>
                <td> <?php echo $value->getAdress(); ?> </td>
                <td> <?php echo $value->getTicketPrice(); ?> </td>
                <td> <?php echo $value->getCapacity(); ?> </td>
                <td>
                  <button type="submit" name="btnRemove" class="btn btn-danger" value="<?php $value->getId(); ?>"> Remove </button>
                </td>
              </tr>

            <?php } ?>

          </tbody>
        </table></form> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
  include('footer.php');
?>