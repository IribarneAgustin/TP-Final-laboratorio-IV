<?php

namespace Controllers;

use DAO\MoviesDAO;
use DAO\MoviesDAOMySQL;
use \Exception as Exception;

class MovieController
{

    private $moviesDAO;
    private $moviesDAOMySQL;

    public function __construct()
    {
        $this->moviesDAO = new MoviesDAO();
        $this->moviesDAOMySQL = new MoviesDAOMySQL();
        try{
            session_start();   
            }catch (Exception $ex) {
                throw $ex;
        }
    }

    public function showList()
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
            $moviesList = $this->moviesDAO->getAll();
            $genresList = $this->moviesDAO->getGenreList();
            $key = $this->moviesDAO->getKey();
            require_once(VIEWS_PATH . "movie-list.php");
        
    }
    public function addAll()
    {
        $moviesList = $this->moviesDAO->getAll();
        foreach ($moviesList as $value) {
            $this->moviesDAOMySQL->add($value);
        }
    }
    public function addGenres()
    {
        $moviesList = $this->moviesDAO->getAll();
        $genresList = $this->moviesDAO->getGenreList();


        foreach ($genresList as $genre) {
            $this->moviesDAOMySQL->addGenre($genre->getId(), $genre->getName());
        }

        foreach ($moviesList as $movie) {
            $genres = $movie->getGenres();
            foreach ($genres as $genre) {
                $this->moviesDAOMySQL->addGenreXmovie($movie->getId(), $genre->getId());
            }
        }
    }
}
