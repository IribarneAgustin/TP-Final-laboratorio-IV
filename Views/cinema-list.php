<?php 
 include('header.php');
 include('nav-bar.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Add</a></li>
        <li><a href="#">List - Remove</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
      <form action="" method="">
        <table style="text-align:center;">
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
                  <button type="submit" name= "id" class="btn" value="<?php $value->getId(); ?>"> Remove </button>
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