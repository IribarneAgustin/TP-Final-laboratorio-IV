<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAO;
use DAO\BillboardDAO;
use Models\Cinema;
use Models\Movie;

class BillboardController
{

    private $moviesDAO;
    private $cinemaDAO;
    private $billboardDAO;


    public function __construct()
    {
        $this->billboardDAO = new BillboardDAO();
        $this->moviesDAO = new MoviesDAO();
        $this->cinemaDAO = new CinemaDAOMySQL();
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

    public function showBillboardMovieList($idCinema, $message = '')
    {
        $billboardMovieList = $this->billboardDAO->getMoviesByCinemaId($idCinema);
        require_once(VIEWS_PATH . "billboardMovies-list.php");
    }

    public function showAddView()
    {
        $genresList = $this->moviesDAO->getGenreList();
        $moviesList = $this->moviesDAO->getAll();
        $cinemaList = $this->cinemaDAO->getAll();
        require_once(VIEWS_PATH . "add-movieToCinemaBillboard.php");
    }

    public function add($cinemaId, $movieId)
    {

        $cinema = $this->cinemaDAO->getById($cinemaId);
        $movie = $this->moviesDAO->getById($movieId);

        if ($this->billboardDAO->onBillboard($movie, $cinema) == false) {          
            $this->billboardDAO->add($movie, $cinema);
            $this->showBillboardMovieList($cinemaId,"Movie added to billboard succesfully");
        }
    }

    public function billboardAdminView($cinemaId)
    {

        $cinema = $this->cinemaDAO->getById($cinemaId);
        $moviesList = $this->billboardDAO->getMoviesBycinemaId($cinemaId);
        $genresList = $this->moviesDAO->getGenreList();
        require_once(VIEWS_PATH . "movie-list.php");
    }
}
