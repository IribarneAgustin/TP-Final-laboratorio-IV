<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAO;
use DAO\MoviesDAOMySQL;
use DAO\MovieShowDAO;
use \Exception as Exception;

class BillboardController
{

    private $moviesDAOMySQL;
    private $cinemaDAO;
    private $movieshowDAO;

    public function __construct()
    {
        $this->moviesDAOMySQL = new MoviesDAOMySQL();
        $this->cinemaDAO = new CinemaDAOMySQL();
        $this->movieshowDAO = new MovieShowDAO();
        try {
            session_start();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    

    public function showFilteredList($date = '', $genreId = '')
    {

        if ($date != "") {
            $movieList = $this->movieshowDAO->getMoviesByDate($date);
            $moviesList = $this->movieshowDAO->filterMovieList($movieList); //Elimino repetidos
            $movieShowList =  $this->movieshowDAO->getByDate($date);
            $genresList = $this->moviesDAOMySQL->getGenreList();
        }
        if ($genreId != "") {

            $movieList = $this->movieshowDAO->getMoviesByGenre($genreId);
            $moviesList = $this->movieshowDAO->filterMovieList($movieList); //Elimino repetidos
            $movieShowList = $this->movieshowDAO->getAll();
            $genresList = $this->moviesDAOMySQL->getGenreList();
        }

        if ($date == '' && $genreId == '') {
            $this->showList();
        } else {
            require_once(VIEWS_PATH . "Billboard-list.php");
        }
    }
    public function getGenresByMovieId($movieId)
    {

        require_once(VIEWS_PATH . "validate-session-logged.php");
        $genresList = $this->moviesDAOMySQL->getGenresByMovieId($movieId);
        return $genresList;
    }

    public function showList()
    {

        require_once(VIEWS_PATH . "validate-session-logged.php");
        $movieShowList = $this->movieshowDAO->getAll();
        $moviesList = $this->movieshowDAO->getMovies();
        $moviesList = $this->movieshowDAO->filterMovieList($moviesList);
        $genresList = $this->moviesDAOMySQL->getGenreList();

        require_once(VIEWS_PATH . "Billboard-list.php");
    }

    public function showAddView()
    {
        require_once(VIEWS_PATH . "validate-session-admin.php");
        $genresList = $this->moviesDAOMySQL->getGenreList();
        $moviesList = $this->moviesDAOMySQL->getAll();
        $cinemaList = $this->cinemaDAO->getAll();
        require_once(VIEWS_PATH . "add-movieToBillboard.php");
    }
}

