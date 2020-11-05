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
        try{
            session_start();   
            }catch (Exception $ex) {
                throw $ex;
        }
    }

    public function showFilteredListByDate($date){

        require_once(VIEWS_PATH."validate-session-logged.php");
        if ($date != "") {
            $moviesList = $this->filterMovieList($this->movieshowDAO->getMoviesByDate($date));
            $movieShowList =  $this->movieshowDAO->getAll();
            $genresList = $this->moviesDAOMySQL->getGenreList();
            require_once(VIEWS_PATH . "Billboard-list.php");
        } else {
            $this->showList();
        }

    }

    public function getGenresByMovieId($movieId){
        
        require_once(VIEWS_PATH."validate-session-logged.php");
        $genresList = $this->moviesDAOMySQL->getGenresByMovieId($movieId);
        return $genresList;
    }

    public function showList(){

        require_once(VIEWS_PATH."validate-session-logged.php");
        $movieShowList = $this->movieshowDAO->getAll();
        $moviesList = $this->movieshowDAO->getMovies();
        $moviesList = $this->movieshowDAO->filterMovieList($moviesList);
        $genresList = $this->moviesDAOMySQL->getGenreList();
        
        require_once(VIEWS_PATH . "Billboard-list.php");

    }
    public function showFilteredListByGenre($genreId)
    {
        require_once(VIEWS_PATH."validate-session-logged.php");
        if ($genreId != "") {
            $moviesList = $this->filterMovieList($this->movieshowDAO->getMoviesByGenre($genreId));
            $movieShowList = $this->movieshowDAO->getAll();
            $genresList = $this->moviesDAOMySQL->getGenreList();
            require_once(VIEWS_PATH . "Billboard-list.php");
        } else {
            $this->showList();
        }
    }

    public function showAddView()
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
            $genresList = $this->moviesDAOMySQL->getGenreList();
            $moviesList = $this->moviesDAOMySQL->getAll();
            $cinemaList = $this->cinemaDAO->getAll();
            require_once(VIEWS_PATH . "add-movieToBillboard.php");
    
    }


}
