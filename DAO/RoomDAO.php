<?php

namespace DAO;

use Models\Room as Room;

class RoomDAO implements IRoomDAO
{

    private $file;
    private $roomList;

    public function __construct()
    {
        $this->file = ROOT . "/Data/rooms.json";
    }

    public function add($room)
    {
        $this->retrieveData();
        $room->setId($this->nextId());
        array_push($this->roomList, $room);
        $this->saveData();
    }

    public function remove($roomId)
    {

        $this->retrieveData();

        foreach ($this->roomList as $roomValue) {

            if ($roomValue->getId() == $roomId) {
                $key = array_search($roomValue, $this->roomList);
                unset($this->roomList[$key]);
            }
        }
        $this->SaveData();
    }

    public function getAll()
    {
        $this->retrieveData();
        return $this->roomList;
    }

    public function nextId()
    {
        $id = 0;
        $this->retrieveData();

        foreach ($this->roomList as $value) {
            $id = $value->getId();
        }

        return $id + 1;
    }


    public function retrieveData()
    {
        $this->roomList = array();

        if (file_exists($this->file)) {

            $jsonContent = file_get_contents($this->file);

            $arrayToDecode = json_decode($jsonContent, true);

            if (is_array($arrayToDecode)) {

                foreach ($arrayToDecode as $valuesArray) {

                    $room = new Room();
                    $room->setId($valuesArray["id"]);
                    $room->setName($valuesArray["name"]);
                    $room->setCapacity($valuesArray["capacity"]);

                    array_push($this->roomList, $room);
                }
            }
        }
    }

    public function saveData()
    {

        $arrayToEncode = array();

        foreach ($this->roomList as $room) {

            $valuesArray["id"] = $room->getId();
            $valuesArray["name"] = $room->getName();
            $valuesArray["capacity"] = $room->getCapacity();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->file, $jsonContent);
    }
    public function update(room $modifiedRoom)
    {
        $this->retrieveData();

        foreach ($this->roomList as $value) {
            if ($value->getId() == $modifiedRoom->getId()) {
                $key = array_search($value, $this->roomList);
                unset($this->roomList[$key]);
                array_push($this->roomList, $modifiedRoom);
            }
        }
        sort($this->roomList);
        $this->saveData();
    }

    public function existsName($name)
    {
        $exists = false;

        $this->retrieveData();
        foreach ($this->roomList as $value) {
            if ($value->getName() == $name) {
                $exists = true;
            }
        }
        
        return $exists;
    }

    public function getById($idRoom)
    {
        $room = new Room();

        $this->retrieveData();
        foreach ($this->roomList as $rooms) {
            if ($rooms->getId() == $idRoom) {
                $room = $rooms;
                break;
            }
        }
        return $room;
    }
}
