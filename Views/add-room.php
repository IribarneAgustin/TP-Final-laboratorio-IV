<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <h2 class="mb-4" style="color:white">Add Room</h2>
        <div class="d-flex justify-content-center align-items-center container">
            <form action="<?php echo FRONT_ROOT ?>Room/add" method="post" class="bg-dark-alpha p-5">
                <input type="hidden" name="cinemaId" value="<?php if (isset($cinemaId)) {echo $cinemaId;} ?>" size="0"
                    required>
                <div class="form-group">
                    <label for="" style="color:white">Name</label>
                    <input type="text" name="name" size="30" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="" style="color:white">Price</label>
                    <input type="number" name="price" size="10" class="form-control" min="0" required>
                </div>
                <div class="form-group">
                    <label for="" style="color:white">Capacity</label>
                    <input type="number" name="capacity" size="10" class="form-control" min="0" required>
                </div>
                <button type="submit" name="button" class="btn btn-dark">Agregar</button>
                <br>
                <br>
                <?php 
               if(isset($message) && $message != "") {echo "<div class='alert alert-primary' role='alert'> $message </div>";}
               ?>

            </form>


        </div>
    </section>
</main>

<?php include('footer.php') ?>