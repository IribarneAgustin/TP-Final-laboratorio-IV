<?php

namespace Controllers;

use DAO\CinemaDAOJson;
use DAO\CinemaDAOMySQL;
use Models\Cinema;
use Controllers\HomeController; 

class CinemaController
{

    private $cinemaDAO;
    private $home;

    public function __construct()
    {
        $this->cinemaDAO = new CinemaDAOMySQL();
        $this->home = new HomeController();
        try{
            session_start();   
            }catch (Exception $ex) {
                throw $ex;
        }
    }

    public function showList($message = "")
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $cinemaList = $this->cinemaDAO->getAll();
            require_once(VIEWS_PATH . "cinema-list.php");
        }else {
            $this->home->index();
        }  
    }

    public function showAddView($message = "")
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            require_once(VIEWS_PATH . "add-cinema.php");
        }else {
            $this->home->index();
        }  
    }

    public function add($name, $address)
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            if ($this->cinemaDAO->existsName($name) == false) {

                $newCinema = new Cinema();
                $newCinema->setName($name);
                $newCinema->setAddress($address);
                $newCinema->setStatus(true);
                $this->cinemaDAO->add($newCinema);
                $this->showAddView($message = "Cinema added succesfully");
            } else {
                $this->showAddView($message = "Name already in use");
            }
        }else {
            $this->home->index();
        }  
    }

    public function activate($cinemaId){
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $this->cinemaDAO->activate($cinemaId);
            $this->showList("Cinema activated succesfully");
        }else {
            $this->home->index();
        }  
    }

    public function remove($cinemaId)
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $this->cinemaDAO->remove($cinemaId);
            $this->showList($message = "Cinema removed succesfully");
        }else {
            $this->home->index();
        }  
    }


    public function modify($id, $field, $newContent)
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $toModify = $this->cinemaDAO->getById($id);

            if ($field == "name" && $this->cinemaDAO->existsName($newContent) == true) {
                $this->showList($message = "Name already in use");

            } else {

                if (isset($toModify)) {

                    $myMethod = "set" . $field;
                    $toModify->$myMethod($newContent);

                    $this->cinemaDAO->update($toModify);
                }

                $this->showList($message = "Cinema modified succesfully");
            }
        }else {
            $this->home->index();
        }  
    }


    public function showRoomList($message=''){

        if ($_SESSION['user']->getRole() === 'admin')
        {
            require_once(VIEWS_PATH . "room-list.php");
        }else {
            $this->home->index();
        } 
    }

}