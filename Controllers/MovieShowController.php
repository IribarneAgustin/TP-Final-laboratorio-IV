<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAO;
use DAO\MovieShowDAO;
use DAO\MovieShowDAOMySQL;
use DAO\RoomDAOMySQL;
use Models\MovieShow;
use Controllers\HomeController; 

class MovieShowController
{

    private $movieShowDAO;
    private $moviesDAO;
    private $cinemasDAO;
    private $home;

    public function __construct()
    {
        $this->movieShowDAO = new movieShowDAO();
        $this->moviesDAO = new MoviesDAO();
        $this->roomDAO = new RoomDAOMySQL();
        $this->cinemasDAO = new CinemaDAOMySQL();
        $this->home = new HomeController();
        try{
            session_start();   
            }catch (Exception $ex) {
                throw $ex;
        }
    }

    public function addView($movieId, $cinemaId)
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $movie = $this->moviesDAO->getById($movieId);
            $roomList = $this->roomDAO->getRoomsByCinemaId($cinemaId);
            require_once(VIEWS_PATH . "add-movieShow.php");
        }else {
            $this->home->index();
        }
    }

    public function dateAndCinemaValidation($movieId, $date)
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $movieShowList = $this->movieShowDAO->getAll();
            $flag = true;

            foreach ($movieShowList as $value) {

                if ($value->getDate() == $date && $value->getMovie()->getId() == $movieId) {
                    $flag = false;
                }
            }
            return $flag;
        }else {
            $this->home->index();
        }
    }

    public function timeValidation($cinemaId, $date, $time)
    {
        if ($_SESSION['user']->getRole() === 'admin')
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
        }else {
            $this->home->index();
        }
    }


    public function add($movieId, $roomId, $date, $time)
    {
        if ($_SESSION['user']->getRole() === 'admin')
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
        }else {
            $this->home->index();
        }
    }


    public function showList($message = '')
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $movieShowList = $this->movieShowDAO->getAll();
            $cinemaList = $this->cinemasDAO->getAll();
            require_once(VIEWS_PATH . "movieShow-admin.php");
        }else {
            $this->home->index();
        }
    }

       
    public function remove($movieShowId)
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $this->movieShowDAO->remove($movieShowId);
            $this->showList($message = "Movie Show removed succesfully");
        }else {
            $this->home->index();
        }
    }

}
