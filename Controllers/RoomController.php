<?php

namespace Controllers;

use DAO\roomDAO;
use Models\Room;


class RoomController
{

    private $roomDAO;


    public function __construct()
    {
        $this->roomDAO = new RoomDAO();
    }

    public function showList($message = "")
    {

        $roomList = $this->roomDAO->getAll();
        require_once(VIEWS_PATH . "room-list.php");
    }

    public function showAddView($message = "")
    {
        require_once(VIEWS_PATH . "add-room.php");
    }

    public function add($name,$capacity)
    {
        if ($this->roomDAO->existsName($name) == false) {

            $newroom = new room();
            $newroom->setName($name);
            $newroom->setCapacity($capacity);

            $this->roomDAO->add($newRoom);
            $this->showAddView();
        } else {
            $this->showAddView($message = "Name already in use");
        }
    }

    public function remove($roomId)
    {

        $this->roomDAO->remove($roomId);

        $this->showList();
    }


    public function modify($id, $field, $newContent)
    {

        $toModify = $this->roomDAO->getById($id);

        if ($field == "name" && $this->roomDAO->existsName($newContent) == true) {
            $this->showList($message = "Name already in use");

        } else {

            if (isset($toModify)) {

                $myMetohd = "set" . $field;
                $toModify->$myMetohd($newContent);

                $this->roomDAO->update($toModify);
            }

            $this->showList();
        }
    }
}
