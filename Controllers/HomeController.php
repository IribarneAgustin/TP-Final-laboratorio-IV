<?php

namespace Controllers;

class HomeController
{

    public function __construct()
    {
    }

    public function index()
    {
        if (isset($_SESSION['user'])) {
            require(VIEWS_PATH . 'userHome.php');
        } else {
            require_once(VIEWS_PATH . "login.php");
        }
    }


}
