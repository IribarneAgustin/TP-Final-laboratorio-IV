<?php

namespace Controllers;

use DAO\MoviesDAO;

class MovieController
{

    private $moviesDAO;


    public function __construct()
    {
        $this->moviesDAO = new MoviesDAO();
    }

    public function showList()
    {
        $moviesList = $this->moviesDAO->getAll();
        $genresList = $this->moviesDAO->getGenreList();
        $key = $this->moviesDAO->getKey();
        require_once(VIEWS_PATH . "movie-list.php");
    }

    public function showFilteredList($genreId)
    {
        if($genreId!=""){
            $moviesList = $this->moviesDAO->getMoviesByGenre($genreId);
            $genresList = $this->moviesDAO->getGenreList();
            $key = $this->moviesDAO->getKey();
            require_once(VIEWS_PATH . "movie-list.php");
        }
        else{
            $this->showList();
        }
    }
/*
    public function sortByGenre()
    {
        
        require_once(VIEWS_PATH . "movie-list.php");

    }

*/
}
