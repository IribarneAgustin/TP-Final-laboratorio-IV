  <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
      <span class="navbar-text" style="color:white">
          MoviePass
      </span>
      <ul class="navbar-nav ml-auto">
          <?php if(isset($_SESSION)){?>
          <?php if($_SESSION['user']->getRole()=="admin"){?>
          <li class="nav-item dropdown show">
              <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                  data-target="#navBarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Admin
              </a>
              <div id="navbarDropdown" class="dropdown-menu bg-dark" role="menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item bg-dark" style="color:white"
                      href="<?php echo FRONT_ROOT;?>Cinema/showList">Cinema
                      List</a>
                  <a class="dropdown-item bg-dark" style="color:white"
                      href="<?php echo FRONT_ROOT;?>Cinema/showAddView">Add
                      Cinema</a>
                  <a class="dropdown-item bg-dark" style="color:white"
                      href="<?php echo FRONT_ROOT;?>Billboard/showAddView">Add
                      to
                      Billboard</a>
                  <a class="dropdown-item bg-dark" style="color:white"
                      href="<?php echo FRONT_ROOT;?>MovieShow/showList">Movie
                      Show
                      Admin</a>
                  <a class="dropdown-item bg-dark" style="color:white"
                      href="<?php echo FRONT_ROOT;?>Ticket/showSalesView">Sale Stats</a>
              </div>
          </li>
          <?php } ?>
          <li class="nav-item">
              <a class="nav-link" style="color:white" href="<?php echo FRONT_ROOT;?>Billboard/showList">Billboard</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" style="color:white" href="<?php echo FRONT_ROOT;?>Ticket/showShoppingCart">Shopping
                  Cart</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" style="color:white" href="<?php echo FRONT_ROOT;?>Ticket/showTicketList">Ticket
                  List</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" style="color:white" href="<?php echo FRONT_ROOT;?>User/logout">Logout</a>
          </li>
          <?php }else{ ?>
          <li class="nav-item">
              <a class="nav-link" style="color:white" href="<?php echo FRONT_ROOT;?>User/showLoginView">Login</a>
          </li>
          <?php } ?>
      </ul>
  </nav>