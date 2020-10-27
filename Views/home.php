<?php
include_once('header.php');
?>


<body>
  <div class="container">
    <div class="row">
      <div class="col-md-5 mx-auto">
        <div id="first">
          <div class="myform form ">
            <div class="logo mb-3">
              <div class="col-md-12 text-center">
                <h1>Login</h1>
              </div>
            </div>
            <form action="<?php echo FRONT_ROOT ?>Home/login" method="post">
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                <input type="password" name="password" id="password" class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
              </div>
              <div class="col-md-12 text-center ">
                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
              </div>
              <div class="col-md-12 ">
                <div class="login-or">
                  <hr class="hr-or">
                  <span class="span-or">or</span>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <div class="container">
                  <a class="btn btn-lg btn-social btn-facebook">
                    <i class="fa fa-facebook fa-fw"></i> Sign in with Facebook
                  </a>
                </div>
              </div>
              <div class="form-group">
                <p class="text-center">Don't have account? <a href="#" id="signup">Sign up here</a></p>
              </div>
            </form>


</body>