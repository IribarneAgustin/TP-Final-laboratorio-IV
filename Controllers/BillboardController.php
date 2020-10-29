<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAO;
use DAO\MoviesDAOMySQL;
use DAO\MovieShowDAO;


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
    
    private function filterMovieList($moviesList){
        $list = array();

        foreach($moviesList as $value){
            if(!in_array($value,$list)){
                array_push($list,$value);
            }
        }

        return $list;
    }

    public function showList(){

        $movieShowList = $this->movieshowDAO->getAll();
        $moviesList = $this->filterMovieList($this->movieshowDAO->getMovies());
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
