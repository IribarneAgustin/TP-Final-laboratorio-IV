<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Add Cinema</h2>
               <form action="<?php echo FRONT_ROOT?>Cinema/add" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-3">
                              <div class="form-group">
                                   <label for="">Name</label>
                                   <input type="text" name="name" size="30" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-3">
                              <div class="form-group">
                                   <label for="">Address</label>
                                   <input type="text" name="address" size="30" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-3">
                              <div class="form-group">
                                   <label for="">Ticket Price</label>
                                   <input type="number" name="ticketPrice" size="10" class="form-control" min="0" required>
                              </div>
                         </div>
                         <div class="col-lg-3">
                              <div class="form-group">
                                   <label for="">Capacity</label>
                                   <input type="number" name="capacity" size="10" class="form-control" min="0" required>
                              </div>
                         </div>
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
               </form>
          </div>
     </section>
</main>

<?php echo $message; ?>


<?php include('footer.php') ?>