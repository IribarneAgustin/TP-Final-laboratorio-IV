<?php
namespace Models;

class Cinema{

    private $id;
    private $capacity;
    private $name;
    private $adress;
    private $ticketPrice;

    public function __construct()
    {
        
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;

    }
 
    public function getAdress()
    {
        return $this->adress;
    }


    public function setAdress($adress)
    {
        $this->adress = $adress;

    }

    public function getTicketPrice()
    {
        return $this->ticketPrice;
    }


    public function setTicketPrice($ticketPrice)
    {
        $this->ticketPrice = $ticketPrice;

    }
}