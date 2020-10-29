<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4" style="color:white">Add Cinema</h2>
               <form action="<?php echo FRONT_ROOT ?>Cinema/add" method="post" class="bg-dark-alpha p-3">
                    <div class="row">
                         <div class="col-lg-3">
                              <div class="form-group">
                                   <label for="" style="color:white">Name</label>
                                   <input type="text" name="name" size="30" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-3">
                              <div class="form-group">
                                   <label for="" style="color:white">Address</label>
                                   <input type="text" name="address" size="30" class="form-control" required>
                              </div>
                         </div>
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
               </form>
               <?php 
               if(isset($message) && $message != "") {echo "<div class='alert alert-primary' role='alert'> $message </div>";}
               ?>
               

          </div>
     </section>
</main>

<?php include('footer.php') ?>