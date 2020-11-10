<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAO;
use DAO\MoviesDAOMySQL;
use DAO\MovieShowDAO;
use DAO\MovieShowDAOMySQL;
use DAO\RoomDAOMySQL;
use Models\MovieShow;
use \FFI\Exception as Exception;

class MovieShowController
{

    private $movieShowDAO;
    private $moviesDAO;
    private $cinemasDAO;


    public function __construct()
    {
        $this->movieShowDAO = new movieShowDAO();
        $this->moviesDAO = new MoviesDAOMySQL();
        $this->roomDAO = new RoomDAOMySQL();
        $this->cinemasDAO = new CinemaDAOMySQL();
        try {
            session_start();
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function getGenresByMovieId($movieId)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        $genresList = $this->moviesDAO->getGenresByMovieId($movieId);
        return $genresList;
    }

    public function addView($movieId, $cinemaId)
    {
        require_once(VIEWS_PATH . "validate-session-admin.php");
        $movie = $this->moviesDAO->getById($movieId);
        $roomList = $this->roomDAO->getRoomsByCinemaId($cinemaId);

        require_once(VIEWS_PATH . "add-movieShow.php");
    }




    public function dateAndCinemaValidation($movieId, $date)
    {
        require_once(VIEWS_PATH . "validate-session-admin.php");
        $movieShowList = $this->movieShowDAO->getAll();
        $flag = true;

        foreach ($movieShowList as $value) {

            if ($value->getDate() == $date && $value->getMovie()->getId() == $movieId && $value->getStatus() == 1) {
                $flag = false;
            }
        }
        return $flag;
    }


    public function timeValidation($room, $date, $time)
    {
        $flag = false;
        $lastTime = $this->movieShowDAO->getTimeToLastMovieShow($room, $date);

        if ($time >= $lastTime) {
            $flag = true;
        }


        return $flag;
    }

    public function add($movieId, $roomId, $date, $time)
    {
        require_once(VIEWS_PATH . "validate-session-admin.php");
        $cinemaId = $this->roomDAO->getCinemaId($roomId);
        //$cinema = $this->cinemasDAO->getById($cinemaId);
        $room = $this->roomDAO->getById($roomId);

        //1º valido que la película solo pueda ser proyectada en un único cine por día
        if ($this->dateAndCinemaValidation($movieId, $date) == true) {

            //2º valido que el comienzo de una funcion sea 15 minutos despues de la anterior
            if ($this->timeValidation($room, $date, $time) == true) {

                $newMovieShow = new MovieShow();
                $newMovieShow->setDate($date);
                $newMovieShow->setTime($time);
                $newMovieShow->setTicketsSold(0);
                $newMovieShow->setStatus(true);
                $this->movieShowDAO->add($newMovieShow, $roomId, $movieId);
                $this->showList("Movie show added succesfully");
            } else {

                $this->showList("Time must be 15 minutes after last show");
            }
        } else {
            $this->showList("Movie is already in a cinema for this day");
        }
    }


    public function showList($message = '')
    {
        require_once(VIEWS_PATH . "validate-session-admin.php");
        $movieShowList = $this->movieShowDAO->getAll();
        $cinemaList = $this->cinemasDAO->getAll();
        require_once(VIEWS_PATH . "movieShow-admin.php");
    }

    public function validateTicketSold(MovieShow $movieShow)
    {
        $flag = false;
        if ($movieShow->getTicketsSold() > 0) {
            $flag = true;
        }
        return $flag;
    }


    public function remove($movieShowId)
    {
        $movieShow = $this->movieShowDAO->getById($movieShowId);
        if ($this->validateTicketSold($movieShow) == false) {
            require_once(VIEWS_PATH . "validate-session-admin.php");
            $this->movieShowDAO->remove($movieShowId);
            $this->showList($message = "Movie Show removed succesfully");
        }else{
            $this->showList($message = "Movie Show cannot be remove because it has tickets sold");
        }
    }
}
