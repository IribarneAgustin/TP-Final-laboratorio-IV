<?php

namespace Controllers;

class HomeController
{

    public function construct()
    {
        try{
            if (!isset($_SESSION)) {
                session_start();
              }
        }catch (Exception $ex) {
            throw $ex;
       }
    }

    public function index()
    {
        if(isset($_SESSION['user'])) {
            require_once(VIEWS_PATH . "header.php");     
            require(VIEWS_PATH . 'add-cinema.php');  
            require_once(VIEWS_PATH . "footer.php");
        } else {
            require_once(VIEWS_PATH . "login.php");
        }
    }


}