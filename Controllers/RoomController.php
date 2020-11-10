<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\roomDAO;
use DAO\RoomDAOMySQL;
use Models\Room;
use \FFI\Exception as Exception;
use DAO\MovieShowDAO;

class RoomController
{

        private $roomDAO;
        private $cinemaDAO;
        private $movieShowDAO;

        public function __construct()
        {
                $this->roomDAO = new RoomDAOMySQL();
                $this->cinemaDAO = new CinemaDAOMySQL();
                $this->movieShowDAO = new MovieShowDAO();
                try {
                        session_start();
                } catch (Exception $ex) {
                        throw $ex;
                }
        }

        public function showListByCinemaId($cinemaId, $message = "")
        {
                require_once(VIEWS_PATH . "validate-session-admin.php");
                $roomList = $this->roomDAO->getRoomsByCinemaId($cinemaId);
                require_once(VIEWS_PATH . "room-list.php");
        }

        public function showList($message = "")
        {
                require_once(VIEWS_PATH . "validate-session-admin.php");
                $roomList = $this->roomDAO->getAll();
                require_once(VIEWS_PATH . "room-list.php");
        }

        public function showAddView($cinemaId, $message = '')
        {
                require_once(VIEWS_PATH . "validate-session-admin.php");
                require_once(VIEWS_PATH . "add-room.php");
        }

        public function showModifyView($roomId, $message = '')
        {
                require_once(VIEWS_PATH . "validate-session-admin.php");
                $room = $this->roomDAO->getById($roomId);
                $cinemaId = $this->roomDAO->getCinemaId($roomId);
                if ($this->validateActiveShows($room) == false) {
                        require_once(VIEWS_PATH . "modify-room.php");
                } else {
                        $this->showListByCinemaId($cinemaId, "Room cannot be modify because it has active shows");
                }
        }

        public function add($cinemaId, $name, $price, $capacity)
        {
                require_once(VIEWS_PATH . "validate-session-admin.php");
                if ($this->roomDAO->existsName($name, $cinemaId) == false) {
                        $newRoom = new Room();
                        $newRoom->setName($name);
                        $newRoom->setCapacity($capacity);
                        $newRoom->setPrice($price);
                        $newRoom->setStatus(true);
                        $cinema = $this->cinemaDAO->getById($cinemaId);
                        $newRoom->setCinema($cinema);
                        $this->roomDAO->add($newRoom);
                        $room = $this->roomDAO->getByName($name);
                        $this->showAddView($cinemaId, "Room added succesfully");
                } else {
                        $this->showAddView($cinemaId, "Name already in use");
                }
        }
        public function validateActiveShows(Room $room)
        {
                $flag = false;

                $movieShowList = $this->movieShowDAO->getMovieShowByRoom($room);
                foreach ($movieShowList as $value) {

                        if ($value->getStatus() == 1) {
                                $flag = true;
                        }
                }

                return $flag;
        }

        public function remove($roomId)
        {
                require_once(VIEWS_PATH . "validate-session-admin.php");
                $room = $this->roomDAO->getById($roomId);
                $cinemaId = $this->roomDAO->getCinemaId($roomId);
                if ($this->validateActiveShows($room) == false) {
                        $this->roomDAO->remove($roomId);
                        $this->showListByCinemaId($cinemaId, "Room removed succesfully");
                } else {
                        $this->showListByCinemaId($cinemaId, "Room cannot be deleted because it has active shows");
                }
        }

        public function activate($roomId)
        {
                require_once(VIEWS_PATH . "validate-session-admin.php");
                $this->roomDAO->activate($roomId);
                $cinemaId = $this->roomDAO->getCinemaId($roomId);
                $this->showListByCinemaId($cinemaId, "Room activated succesfully");
        }


        public function modify($id, $field, $newContent)
        {
                require_once(VIEWS_PATH . "validate-session-admin.php");
                $toModify = $this->roomDAO->getById($id);
                $cinemaId = $toModify->getCinema()->getId();
                if ($field == "name" && $this->roomDAO->existsName($newContent, $cinemaId) == true) {
                        $this->showModifyView($id, "Name already in use");
                } else {

                        if (isset($toModify)) {

                                $myMethod = "set" . $field;
                                $toModify->$myMethod($newContent);

                                $this->roomDAO->update($toModify);
                        }

                        $this->showListByCinemaId($cinemaId, "Room modified succesfully");
                }
        }
}
