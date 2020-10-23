<?php

namespace Controllers;

use DAO\MoviesDAO;


class BillboardController
{

    private $moviesDAO;
    private $billboardDAO;


    public function __construct()
    {
        $this->moviesDAO = new MoviesDAO();
    }
    public function showAddView()
    {
        $moviesList= $this->moviesDAO->getAll();
        require_once(VIEWS_PATH . "add-billboard.php");
    }

    public function add($initDate, $finishDate, $movies)
    {
    }
}
