<?php

namespace Controllers;

use DAO\MovieShowDAO;
use DAO\MovieShowDAOMySQL;
use Models\MovieShow;

class MovieShowController
{

    private $movieShowDAO;

    public function __construct()
    {
        $this->movieShowDAO = new movieShowDAOMySQL();
    }

    public function showListByroomId($roomId, $message = "")
    {
        $movieShowList = $this->movieShowDAO->getMovieShowsByRoomId($roomId);
        require_once(VIEWS_PATH . "movieShow-list.php");
    }

    public function showList($message = "")
    {

        $movieShowList = $this->movieShowDAO->getAll();
        require_once(VIEWS_PATH . "movieShow-list.php");
    }

    public function showAddView($roomId, $message = '')
    {
        require_once(VIEWS_PATH . "add-movieShow.php");
    }

    public function add($roomId, $date, $time, $ticketsSold)
    {
        if ($this->movieShowDAO->existsName($name,$roomId) == false) {
            $newMovieShow = new movieShow();
            $newMovieShow->setDate($date);
            $newMovieShow->setTime($time);
            $newMovieShow->setTicketsSold($ticketsSold);
            $this->movieShowDAO->add($newMovieShow, $roomId);
            $movieShow = $this->movieShowDAO->getById($name);
            $this->showAddView($roomId, "Movie Show added succesfully");       
        } else {
            $this->showAddView($roomId, "Name already in use");
        }
    }

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

        
    }
}