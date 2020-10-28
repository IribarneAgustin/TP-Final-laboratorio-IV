<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAO;
use DAO\BillboardDAO;
use DAO\MovieShowDAO;
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
        $this->movieshowDAO = new MovieShowDAO();
    }

    public function showList(){
        $movieShowList = $this->movieshowDAO->getAll();
        $movieList = $this->movieshowDAO->getMovies();
        
        require_once(VIEWS_PATH . "Billboard-list.php");
            

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
        require_once(VIEWS_PATH . "add-movieToBillboard.php");
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

}
