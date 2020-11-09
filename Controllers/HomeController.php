<?php

namespace Controllers;

use DAO\MoviesDAOMySQL;
use DAO\MovieShowDAO;
use DAO\CinemaDAOMySQL;

class HomeController
{
    private $moviesDAOMySQL;
    private $cinemaDAO;
    private $movieshowDAO;

    public function __construct()
    {
        $this->moviesDAOMySQL = new MoviesDAOMySQL();
        $this->movieshowDAO = new MovieShowDAO();
        $this->cinemaDAO = new CinemaDAOMySQL();

    }

    public function index()
    {
        $movieShowList = $this->movieshowDAO->getAll();
        $moviesList = $this->movieshowDAO->getMovies();
        $moviesList = $this->movieshowDAO->filterMovieList($moviesList);

        if (isset($_SESSION['user'])) {
            require(VIEWS_PATH . 'userHome.php');
        } else {
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function getGenresByMovieId($movieId){
        $genresList = $this->moviesDAOMySQL->getGenresByMovieId($movieId);
        return $genresList;
    }
    
    
}