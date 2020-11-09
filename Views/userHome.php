<?php
include('header.php');
include('nav-bar.php');
?>

<div class="container">
    <div class="card border-0 shadow my-5 bg-dark">
        <div class="card-body p-5">
            <p class="lead mb-0" style="color:white">Welcome to MoviePass,
                <?php echo $_SESSION['user']->getUsername()?>!</p>
            <br>
            <a class="dropdown-item bg-dark" style="color:white"
                href="<?php echo FRONT_ROOT;?>Billboard/showList">Billboard</a>
            <a class="dropdown-item bg-dark" style="color:white"
                href="<?php echo FRONT_ROOT;?>Ticket/showTicketList">Your
                Profile</a>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>