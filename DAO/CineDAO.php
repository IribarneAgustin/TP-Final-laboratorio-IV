<?php

namespace DAO;

use Models\Cine as Cine;

class CineDAO implements ICineDAO
{

    private $file;
    private $cineList;

    public function __construct()
    {
        $this->file = ROOT . "/Data/cines.json";
    }

    public function add($cine)
    {
        $this->retrieveData();
        $cine->setId($this->nextId());
        array_push($this->cineList, $cine);
        $this->saveData();
    }
    public function getAll()
    {
        $this->retrieveData();
        return $this->cineList;
    }

    public function nextId()
    {
        $id = 0;
        $this->retrieveData();

        foreach ($this->cineList as $value) {
            $id = $value->getId();
        }

        return $id + 1;
    }


    public function retrieveData()
    {
        $this->cineList = array();

        if (file_exists($this->file)) {

            $jsonContent = file_get_contents($this->file);

            $arrayToDecode = json_decode($jsonContent, true);

            if (is_array($arrayToDecode)) {

                foreach ($arrayToDecode as $valuesArray) {

                    $cine = new Cine();
                    $cine->setId($valuesArray["id"]);
                    $cine->setName($valuesArray["name"]);
                    $cine->setAdress($valuesArray["adress"]);
                    $cine->setTicketPrice($valuesArray["ticketPrice"]);
                    $cine->setCapacity($valuesArray["capacity"]);

                    array_push($this->cineList, $cine);
                }
            }
        }
    }


    public function saveData()
    {

        $arrayToEncode = array();

        foreach ($this->cineList as $cine) {

            $valuesArray["id"] = $cine->getId();
            $valuesArray["name"] = $cine->getName();
            $valuesArray["adress"] = $cine->getAdress();
            $valuesArray["ticketPrice"] = $cine->getTicketPrice();
            $valuesArray["capacity"] = $cine->getCapacity();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->file, $jsonContent);
    }
}
