<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <h2 class="mb-4" style="color:white">Modify Cinema</h2>
        <div class="d-flex justify-content-center align-items-center container">
            <form action="<?php echo FRONT_ROOT . "Cinema/modify" ?>" class="bg-dark-alpha p-5">
                <h6 class="mb-4" style="color:white">Name: <?php echo $cinema->getName();?>
                </h6>
                <h6 class="mb-4" style="color:white">Address: <?php echo $cinema->getAddress();?></h6>

                <input id="id" name="id" type="hidden" value="<?php echo $cinema->getId();?>">

                <select name="field" class="form-control" placeholder="field">
                    <option value="name">Name</option>
                    <option value="address">Address</option>
                </select>
                <br>
                <input type="" name=newValue class="form-control" placeholder="New value">
                <br>
                <div class="col">
                    <button type="submit" name="modify" class="btn btn-danger" value=""> Modify</button>
                </div>
                <br>
                <?php 
               if(isset($message) && $message != "") {echo "<div class='alert alert-primary' role='alert'> $message </div>";}
               ?>
        </div>

        </form>
        <br>



        </div>
    </section>
</main>

<?php include('footer.php') ?>