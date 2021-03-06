<?php
include_once('header.php');
?>
<main class="py-4" style="background-image: url('<?php echo FRONT_ROOT ?>Assets/img/header.jpg');">
    <br><br><br><br>
    <section id="cover" class="min-vh-100">
        <div id="cover-caption">
            <div class="container">
                <div class="row text-white">
                    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                        <h1 class="display-4 py-2 text-truncate">Sign up</h1>
                        <div class="px-2">
                            <form action="<?php echo FRONT_ROOT ?>User/signup" method="post" class="justify-content-center">
                                <div class="form-group">
                                    <label class="sr-only">Userame</label>
                                    <input name="username" type="text" class="form-control" placeholder="username">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">Email</label>
                                    <input name="email" type="text" class="form-control" placeholder="email">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">Password</label>
                                    <input name="password " type="password" class="form-control" placeholder="password">
                                </div>
                                <button type="submit" class="btn btn-outline-light">Sign up</button>
                            </form>
                        </div>
                        <br>
                        <?php
                        if (isset($message) && $message != "") {
                            echo "<div class='alert alert-primary' role='alert'> $message </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
