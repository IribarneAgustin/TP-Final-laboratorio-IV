<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAO;
use DAO\BillboardDAO;
use Models\Cinema;

class BillboardController
{

    private $moviesDAO;
    private $cinemaDAO;
    private $billboardDAO;


    public function __construct()
    {
        $this->billboardDAO = new billboardDAO();
    }

    public function showFilteredList($genreId)
    {
        //Filtrar usando tabla de PeliculasXgenero y JOIN con PeliculasXcine***********

        //if($genreId!=""){
        //    $moviesList = $this->moviesDAO->getMoviesByGenre($genreId);
        //    $genresList = $this->moviesDAO->getGenreList();
        //    $key = $this->moviesDAO->getKey();
        //    require_once(VIEWS_PATH . "add-to-cinema.php");
        //}
        //else{
        //    $this->showAddMovieView();
        //}
    }
    public function showBillboardMovieList($idCinema, $message = ''){
        $BillboardMovieList = $this->billboardDAO->getMoviesByCinemaId($idCinema);
        require_once(VIEWS_PATH . "billboardMovies-list.php");

    }

    public function showAddView()
    {
        $genresList = $this->moviesDAO->getGenreList();
        $moviesList= $this->moviesDAO->getAll();
        $cinemaList = $this->cinemaDAO->getAll();
        require_once(VIEWS_PATH . "add-movieToCinemaBillboard.php");
    
    }

    public function add(Cinema $cinema, Movie $movie)
    }
        //Validar que no se encuentre en la cartelera
        $this->billboardDAO->add($cinema,$movie);
        $this->showBillboardMovieList("Movie added to cinema succesfully");
 
    }

    public function billboardAdminView($cinemaId){
        
        $cinema = $this->cinemaDAO->getById($cinemaId);
        $moviesList = $this->billboardDAO->getMoviesBycinemaId($cinemaId);
        $genresList = $this->moviesDAO->getGenreList();
        require_once(VIEWS_PATH. "movie-list.php");


    }

}
