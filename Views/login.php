<?php
include_once('header.php');
?>

<body>
    <br>
    <div class="bg-dark-alpha">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div id="first">
                    <div class="myform form ">
                        <div class="logo mb-3">
                            <div class="col-md-12">
                                <h1 style="color:white">Login</h1>
                            </div>
                        </div>
                        <form action="<?php echo FRONT_ROOT ?>User/login" method="post">
                            <div class="form-group">
                                <label for="exampleInputUsername" style="color:white">Username</label>
                                <input type="username" name="username" class="form-control" id="username"
                                    placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword" style="color:white">Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Enter password">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark">Login</button>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="form-group">
                        <p class="text-center" style="color:white">Don't have account? <a
                                href="<?php echo FRONT_ROOT ?>User/showSignupView" id="signup"> Sign up
                                here</a></p>
                    </div>
                    </form>
                </div>
                <?php
                        if (isset($message) && $message != "") {
                            echo "<div class='alert alert-primary' role='alert'> $message </div>";
                        }
                        ?>
            </div>
        </div>
    </div>
    </div>

</body>