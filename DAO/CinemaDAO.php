<?php

namespace DAO;

use Models\Cinema as Cinema;

class CinemaDAO implements ICinemaDAO
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

    public function remove($cinemaId){

        $this->RetrieveData();

        foreach($this->cinemaList as $cinemaValue){

            if($cinemaValue->getId()==$cinemaId){
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
                    $cinema->setAdress($valuesArray["adress"]);
                    $cinema->setTicketPrice($valuesArray["ticketPrice"]);
                    $cinema->setCapacity($valuesArray["capacity"]);

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
            $valuesArray["adress"] = $cinema->getAdress();
            $valuesArray["ticketPrice"] = $cinema->getTicketPrice();
            $valuesArray["capacity"] = $cinema->getCapacity();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->file, $jsonContent);
    }
}
