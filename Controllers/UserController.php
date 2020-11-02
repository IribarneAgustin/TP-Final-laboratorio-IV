<?php

namespace Controllers;

use Controllers\HomeController; 
use DAO\UserDAO;
use Models\User;

class UserController
{
    private $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->home = new HomeController();
    }

    public function login($username, $password)
    {
        try{
            if (!isset($_SESSION)) {
                session_start();
            }
        }catch (Exception $ex) {
            throw $ex;
        }

        $user = $this->userDAO->getByUsername($username);
        if ($user!=null){
            if($user->getPassword() === $password) {
                $_SESSION['user'] = $user;
            }
        }
       
        $this->home->index();
    }

    public function showLoginView($message = "")
    {
        require_once(VIEWS_PATH . "login.php");
    }

    public function showSignupView($message = "")
    {
        require_once(VIEWS_PATH . "user-signup.php");
    }

    public function signup($username, $email, $password)
    {
        if ($this->userDAO->existsUser($username, $email) == false){

            $newUser = new User();
            $newUser->setUsername($username);
            $newUser->setEmail($email);
            $newUser->setPassword($password);
            $newUser->setRole("user");
            $this->userDAO->add($newUser);
            $this->showLoginView($message = "User registered succesfully. Log in to proceed.");
            
        } else {
            $this->showSignupView($message = "Username or email are already in use");
        }
    }

    public function logout(){

        try{
            if (!isset($_SESSION)) {
                session_destroy();
                session_unset();
            }
        }catch (Exception $ex) {
            throw $ex;
        }

       $this->home->index();
    }
}