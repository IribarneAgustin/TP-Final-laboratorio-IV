<?php

namespace Controllers;

class HomeController
{
    private $userDAO;

    public function construct()
    {
        //   $this->userDAO = new UserDAO();
    }

    public function Index()
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function login($username, $password)
    {

        $user = $this->userDAO->getByUserName($username);

        if (($user != null) && ($user->getPassword() === $password)) {
            $_SESSION['loggedUser'] = $user;
            require_once(VIEWS_PATH . "add-cinema.php");
        } else {

            $this->Index("Datos ingresados incorrectamente");
        }
    }

    public function registerUserView(){
        require_once("register-user.php");
    }

    public function registerUser()
    {

    }
}
