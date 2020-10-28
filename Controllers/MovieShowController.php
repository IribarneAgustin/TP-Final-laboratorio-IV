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

    public function addView($movieId,$cinemaId)
    {

         $movie = $this->moviesDAO->getById($movieId);
         $roomList = $this->roomDAO->getRoomsByCinemaId($cinemaId);
         require_once(VIEWS_PATH . "add-movieShow.php");
    }


    public function add($movieId, $roomId, $date, $time)
    {
        //hacer validaciones
        $newMovieShow = new movieShow();
        $newMovieShow->setDate($date);
        $newMovieShow->setTime($time);
        $newMovieShow->setTicketsSold(0);
        $this->movieShowDAO->add($newMovieShow, $roomId, $movieId);
        $this->showList("Movie show added succesfully");
    }


    public function showList($message = ''){
        $movieShowList = $this->movieShowDAO->getAll();
        $cinemaList = $this->cinemasDAO->getAll();
        require_once(VIEWS_PATH . "billboard-admin.php");
    }

/*
    public function remove($movieShowId)
    {
        $this->movieShowDAO->remove($movieShowId);
        $this->showList($message = "Movie Show removed succesfully");
    }


    public function modify($id, $field, $newContent)
    {

        $toModify = $this->movieShowDAO->getById($id);

        if (isset($toModify)) {

            $myMethod = "set" . $field;
            $toModify->$myMethod($newContent);
            $this->movieShowDAO->update($toModify);
            $roomId = $this->movieShowDAO->getRoomId($toModify->getId());
            $this->showListByRoomId($roomId);
        }else{
            $this->showList();
        }

        
    }*/
}
