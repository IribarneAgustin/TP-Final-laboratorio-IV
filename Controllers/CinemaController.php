<?php

namespace Controllers;

use DAO\CinemaDAOJson;
use DAO\CinemaDAOMySQL;
use Models\Cinema;
use \Exception as Exception;

class CinemaController
{

    private $cinemaDAO;

    public function __construct()
    {
        $this->cinemaDAO = new CinemaDAOMySQL();
        try{
            session_start();   
            }catch (Exception $ex) {
                throw $ex;
        }
    }

    public function showList($message = "")
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
            $cinemaList = $this->cinemaDAO->getAll();
            require_once(VIEWS_PATH . "cinema-list.php");
       
    }

    public function showAddView($message = "")
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
            require_once(VIEWS_PATH . "add-cinema.php");
       
    }

    public function add($name, $address)
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
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
        
    }

    public function activate($cinemaId){
            require_once(VIEWS_PATH."validate-session-admin.php");
            $this->cinemaDAO->activate($cinemaId);
            $this->showList("Cinema activated succesfully");
       
    }

    public function remove($cinemaId)
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
            $this->cinemaDAO->remove($cinemaId);
            $this->showList($message = "Cinema removed succesfully");
       
    }


    public function modify($id, $field, $newContent)
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
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
        
    }


    public function showRoomList($message=''){

            require_once(VIEWS_PATH."validate-session-admin.php");
            require_once(VIEWS_PATH . "room-list.php");
       
    }

}