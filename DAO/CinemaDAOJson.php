<?php

namespace DAO;

use Models\Cinema as Cinema;
use Models\Room as Room;

class CinemaDAOJson implements ICinemaDAO
{

    private $file;
    private $cinemaList;

    public function __construct()
    {
        $this->file = ROOT . "/Data/cinemas.json";
    }

    public function add($cinema)
    {
        $this->retrieveData();
        $cinema->setId($this->nextId());
        array_push($this->cinemaList, $cinema);
        $this->saveData();
    }

    public function remove($cinemaId)
    {

        $this->retrieveData();

        foreach ($this->cinemaList as $cinemaValue) {

            if ($cinemaValue->getId() == $cinemaId) {
                $key = array_search($cinemaValue, $this->cinemaList);
                unset($this->cinemaList[$key]);
            }
        }
        $this->SaveData();
    }

    public function getAll()
    {
        $this->retrieveData();
        return $this->cinemaList;
    }

    public function nextId()
    {
        $id = 0;
        $this->retrieveData();

        foreach ($this->cinemaList as $value) {
            $id = $value->getId();
        }

        return $id + 1;
    }


    public function retrieveData()
    {
        $this->cinemaList = array();

        if (file_exists($this->file)) {

            $jsonContent = file_get_contents($this->file);

            $arrayToDecode = json_decode($jsonContent, true);

            if (is_array($arrayToDecode)) {

                foreach ($arrayToDecode as $valuesArray) {

                    $cinema = new Cinema();
                    $cinema->setId($valuesArray["id"]);
                    $cinema->setName($valuesArray["name"]);
                    $cinema->setAddress($valuesArray["address"]);
                    $cinema->setTicketPrice($valuesArray["ticketPrice"]);
                    $cinema->setCapacity($valuesArray["capacity"]);

                    //Creo objetos room para agregarlos al cine  
                    if (isset($valuesArray["rooms"])) {
                        foreach ($valuesArray["rooms"] as $rooms) {

                            $room = new Room();
                            $room->setId($rooms['id']);
                            $room->setName($rooms['name']);
                            $room->setPrice($rooms['price']);
                            $room->setCapacity($rooms['capacity']);

                            $cinema->addRoom($room);
                        }
                    }


                    array_push($this->cinemaList, $cinema);
                }
            }
        }
    }

    public function saveData()
    {

        $arrayToEncode = array();

        foreach ($this->cinemaList as $cinema) {

            $valuesArray["id"] = $cinema->getId();
            $valuesArray["name"] = $cinema->getName();
            $valuesArray["address"] = $cinema->getAddress();
            $valuesArray["ticketPrice"] = $cinema->getTicketPrice();
            $valuesArray["capacity"] = $cinema->getCapacity();

            /* Creo array asociativo para las rooms*/
            $rooms = array();
            foreach ($cinema->getRooms() as $room) {



                $valuesRoom['id'] = $room->getId();
                $valuesRoom['name'] = $room->getName();
                $valuesRoom['price'] = $room->getPrice();
                $valuesRoom['capacity'] = $room->getCapacity();

                array_push($rooms, $valuesRoom);
            }

            if (isset($rooms)) {
                $valuesArray["rooms"] = $rooms;
            }

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->file, $jsonContent);
    }
    public function update(Cinema $modifiedCinema)
    {
        $this->retrieveData();

        foreach ($this->cinemaList as $value) {
            if ($value->getId() == $modifiedCinema->getId()) {
                $key = array_search($value, $this->cinemaList);
                unset($this->cinemaList[$key]);
                array_push($this->cinemaList, $modifiedCinema);
            }
        }
        sort($this->cinemaList);
        $this->saveData();
    }

    public function existsName($name)
    {
        $exists = false;

        $this->retrieveData();
        foreach ($this->cinemaList as $value) {
            if ($value->getName() == $name) {
                $exists = true;
            }
        }

        return $exists;
    }

    public function getById($idCinema)
    {
        $cinema = false;

        $this->retrieveData();
        foreach ($this->cinemaList as $cinemas) {
            if ($cinemas->getId() == $idCinema) {
                $cinema = $cinemas;
                break;
            }
        }
        return $cinema;
    }


    public function updateRoom($modifiedRoom)
    {

        $this->retrieveData();
        foreach ($this->cinemaList as $cinema) {

            $rooms = $cinema->getRooms();
            foreach ($rooms as $room) {

                if ($room->getId() == $modifiedRoom->getId()) {
                    $key = array_search($room, $rooms);
                    unset($rooms[$key]);
                    array_push($rooms,$modifiedRoom);
                    $cinema->setRooms($rooms);
                    $this->saveData();
                }
            }

         
        }
    }

    public function removeRoom($roomId){

        $this->retrieveData();
        
        foreach($this->cinemaList as $cinema){

            $rooms = $cinema->getRooms();

            foreach ($rooms as $room) {

                if ($room->getId() == $roomId) {
                    $key = array_search($room, $rooms);
                    unset($rooms[$key]);
                    $cinema->setRooms($rooms);
                    $this->saveData();
                }
            }

        }



    }
}
