<?php

namespace Controllers;

use DAO\BillboardDAOMySQL;
use DAO\MoviesDAO;
use DAO\MovieXbillboardDAOMySQL;
use Models\Billboard;

class BillboardController
{

    private $moviesDAO;
    private $billboardDAO;
    private $movieXbillboardDAO;


    public function __construct()
    {
        $this->moviesDAO = new MoviesDAO();
        $this->billboardDAO = new BillboardDAOMySQL();
        $this->movieXbillboardDAO = new MovieXbillboardDAOMySQL();
    }

    public function showFilteredList($genreId)
    {
        if($genreId!=""){
            $moviesList = $this->moviesDAO->getMoviesByGenre($genreId);
            $genresList = $this->moviesDAO->getGenreList();
            $key = $this->moviesDAO->getKey();
            require_once(VIEWS_PATH . "add-to-billboard.php");
        }
        else{
            $this->showAddMovieView();
        }
    }
    public function showBillboardList($message = ''){
        $billboardList = $this->billboardDAO->getAll();
        require_once(VIEWS_PATH . "billboard-list.php");

    }
    public function showAddView(){
        require_once(VIEWS_PATH . "add-billboard.php");
    }

    public function add($billboardName){
        //Validar que no exista el nombre
        $billboard = new Billboard();
        $billboard->setName($billboardName);
        $billboard->setStatus(true);
        $this->billboardDAO->add($billboard);
        $this->showBillboardList("Billboard added succesfully");
        
    }

    public function showAddMovieView()
    {
        $genresList = $this->moviesDAO->getGenreList();
        $moviesList= $this->moviesDAO->getAll();
        $billboardList = $this->billboardDAO->getAll();
        require_once(VIEWS_PATH . "add-to-billboard.php");
    
    }

    public function addMovieToBillboard($billboardId,$movieId){

        //Validar que no se encuentre en la cartelera
        $billboard = $this->billboardDAO->getById($billboardId);
        $movie = $this->moviesDAO->getById($movieId);
        $this->movieXbillboardDAO->add($billboard,$movie);
 
    }

    public function billboardAdminView($billboardId){
        
        $billboard = $this->billboardDAO->getById($billboardId);
        $moviesList = $this->movieXbillboardDAO->getMoviesByBillboardId($billboardId);
        $gernesList = $this->moviesDAO->getGenreList();
        require_once(VIEWS_PATH. "movie-list.php");


    }

}
