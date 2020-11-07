<?php
include('header.php');
include('nav-bar.php');
?>

<main class="py-4">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4" style="color:white">Modify Room</h2>
            <form action="<?php echo FRONT_ROOT . "Room/modify" ?>" class="bg-dark-alpha p-3">
                <h6 class="mb-4" style="color:white">Name: <?php echo $room->getName();?>
                </h6>
                <h6 class="mb-4" style="color:white">Capacity: <?php echo $room->getCapacity();?></h6>
                <h6 class="mb-4" style="color:white">Ticket Price: <?php echo $room->getPrice();?></h6>
                <div class="form-row">
                    <input id="id" name="id" type="hidden" value="<?php echo $room->getId();?>">
                    <div class="col">
                        <select name="field" class="form-control" placeholder="field">
                            <option value="name">Name</option>
                            <option value="capacity">Capacity</option>
                            <option value="price">Price</option>
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
               if(isset($message) && $message != "") {echo "<div class='alert alert-primary' role='alert'> $message </div>";}
               ?>


        </div>
    </section>
</main>

<?php include('footer.php') ?>