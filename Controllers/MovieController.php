<?php

namespace Controllers;

use DAO\MoviesDAO;

class MovieController
{

    private $moviesDAO;


    public function __construct()
    {
        $this->moviesDAO = new MoviesDAO();
    }

    public function showList()
    {
        $moviesList = $this->moviesDAO->getAll();
        $key = $this->moviesDAO->getKey();
        require_once(VIEWS_PATH . "movie-list.php");
    }

    public function test()
    {
        $moviesList = $this->moviesDAO->getAll();

        
    }
}
