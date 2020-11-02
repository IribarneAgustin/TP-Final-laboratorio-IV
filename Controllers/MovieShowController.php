<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAO;
use DAO\MovieShowDAO;
use DAO\MovieShowDAOMySQL;
use DAO\RoomDAOMySQL;
use Models\MovieShow;

class MovieShowController
{

    private $movieShowDAO;
    private $moviesDAO;
    private $cinemasDAO;

    public function __construct()
    {
        $this->movieShowDAO = new movieShowDAO();
        $this->moviesDAO = new MoviesDAO();
        $this->roomDAO = new RoomDAOMySQL();
        $this->cinemasDAO = new CinemaDAOMySQL();
    }

    public function addView($movieId, $cinemaId)
    {

        $movie = $this->moviesDAO->getById($movieId);
        $roomList = $this->roomDAO->getRoomsByCinemaId($cinemaId);
        require_once(VIEWS_PATH . "add-movieShow.php");
    }

    public function dateAndCinemaValidation($movieId, $date)
    {

        $movieShowList = $this->movieShowDAO->getAll();
        $flag = true;

        foreach ($movieShowList as $value) {

            if ($value->getDate() == $date && $value->getMovie()->getId() == $movieId) {
                $flag = false;
            }
        }

        return $flag;
    }

    public function timeValidation($cinemaId, $date, $time)
    {

        $movieShowList = $this->movieShowDAO->getAll();
        $flag = true;

        foreach ($movieShowList as $value) {

            $id = $this->roomDAO->getCinemaId($value->getRoom()->getId());
            $t = strtotime($value->getTime());
            $t2 = strtotime($time);

            
            if ($value->getDate() == $date && $id == $cinemaId && $t == $t2) {
                $flag = false;
            }
        }
        return $flag;
    }


    public function add($movieId, $roomId, $date, $time)
    {
        $cinemaId = $this->roomDAO->getCinemaId($roomId);

        //1º valido que la película solo pueda ser proyectada en un único cine por día
        if ($this->dateAndCinemaValidation($movieId, $date) == true) {

            //2º valido que el comienzo de una funcion sea 15 minutos despues de la anterior
            if ($this->timeValidation($cinemaId, $date, $time) == true) {

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
        $movieShowList = $this->movieShowDAO->getAll();
        $cinemaList = $this->cinemasDAO->getAll();
        require_once(VIEWS_PATH . "movieShow-admin.php");
    }

       
    public function remove($movieShowId)
    {
        $this->movieShowDAO->remove($movieShowId);
        $this->showList($message = "Movie Show removed succesfully");
    }

}
