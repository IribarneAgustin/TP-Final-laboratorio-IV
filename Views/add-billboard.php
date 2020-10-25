<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Add new billboard</h2>
               <form action="<?php echo FRONT_ROOT ?>Billboard/add" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-3">
                              <div class="form-group">
                                   <label for="">Name</label>
                                   <input type="text" name="name" size="30" class="form-control" required>
                              </div>
                         </div>
    
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
               </form>
               <?php 
               if(isset($message) && $message != "") {echo "<div class='alert alert-danger' role='alert'> $message </div>";}
               ?>
               

          </div>
     </section>
</main>

<?php include('footer.php') ?>