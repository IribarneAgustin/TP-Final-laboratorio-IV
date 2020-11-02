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
                            <div class="col-md-12 text-center">
                                <h1 style="color:white">Login</h1>
                            </div>
                        </div>
                        <form action="<?php echo FRONT_ROOT ?>Home/login" method="post">
                            <div class="form-group">
                                <label for="exampleInputEmail1" style="color:white">Email address</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" style="color:white">Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    aria-describedby="emailHelp" placeholder="Enter Password">
                            </div>
                            <div class="col-md-12 text-center ">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
                            </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <p class="text-center" style="color:white">Don't have account? <a
                                href="<?php echo FRONT_ROOT ?>Home/registerUserView" id="signup"> Sign up
                                here</a></p>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>