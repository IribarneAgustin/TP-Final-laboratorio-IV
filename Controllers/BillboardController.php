<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAO;
use DAO\BillboardDAO;
use DAO\MoviesDAOMySQL;
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
        $this->moviesDAOMySQL = new MoviesDAOMySQL();
        $this->cinemaDAO = new CinemaDAOMySQL();
        $this->movieshowDAO = new MovieShowDAO();
    }

    public function showFilteredListByDate($date){

        if ($date != "") {
            $moviesList = $this->movieshowDAO->getMoviesByDate($date);
            $movieShowList =  $movieShowList = $this->movieshowDAO->getAll();
            $genresList = $this->moviesDAOMySQL->getGenreList();
            require_once(VIEWS_PATH . "Billboard-list.php");
        } else {
            $this->showList();
        }
        

    }

    public function getGenresByMovieId($movieId){
        $genresList = $this->moviesDAOMySQL->getGenresByMovieId($movieId);
        return $genresList;
    }

    public function showList(){

        $movieShowList = $this->movieshowDAO->getAll();
        $moviesList = $this->movieshowDAO->getMovies();
        $genresList = $this->moviesDAOMySQL->getGenreList();
        
        require_once(VIEWS_PATH . "Billboard-list.php");

    }
    public function showFilteredListByGenre($genreId)
    {
        if ($genreId != "") {
            $moviesList = $this->movieshowDAO->getMoviesByGenre($genreId);
            $movieShowList =  $movieShowList = $this->movieshowDAO->getAll();
            $genresList = $this->moviesDAOMySQL->getGenreList();
            require_once(VIEWS_PATH . "Billboard-list.php");
        } else {
            $this->showList();
        }
    }


    public function showAddView()
    {
        $genresList = $this->moviesDAOMySQL->getGenreList();
        $moviesList = $this->moviesDAOMySQL->getAll();
        $cinemaList = $this->cinemaDAO->getAll();
        require_once(VIEWS_PATH . "add-movieToBillboard.php");
    }


}
