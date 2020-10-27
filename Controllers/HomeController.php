<?php
    namespace Controllers;

    class HomeController
    {
        private $userDAO;
        
        public function construct()
        {
         //   $this->userDAO = new UserDAOMySQL();
        }

        public function Index()
        {
            require_once(VIEWS_PATH."add-cinema.php");
        }       

        public function login($username, $password)
        {
    
            $user = $this->userDAO->getByUserName($username);
    
            if (($user != null) && ($user->getPassword() === $password)) {
                $_SESSION['loggedUser'] = $user;
                require_once(VIEWS_PATH . "add-cellphone.php");
            } else {
               
                $this->Index("Datos ingresados incorrectamente");
            }
        }
    }
