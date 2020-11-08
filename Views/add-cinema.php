<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <h2 class="mb-4" style="color:white">Add Cinema</h2>
        <div class="d-flex justify-content-center align-items-center container">
            <form action="<?php echo FRONT_ROOT ?>Cinema/add" method="get" class="bg-dark-alpha p-5">
                <div class="form-group">
                    <label for="" style="color:white">Name</label>
                    <input type="text" name="name" size="30" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="" style="color:white">Address</label>
                    <input type="text" name="address" size="30" class="form-control" required>
                </div>
                <div class="col-md-12">
                    <button type="submit" name="button" class="btn btn-dark">Add</button>
                </div>
                <br>
                <?php 
               if(isset($message) && $message != "") {echo "<div class='alert alert-primary' role='alert'> $message </div>";}
               ?>
            </form>
        </div>
        
    </section>
</main>

<?php include('footer.php') ?>