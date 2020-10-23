<?php

namespace Models;

class Room
{
    private $id;
    private $name;
    private $price;
    private $capacity;
    private $cinemaId;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    public function getCinemaId()
    {
        return $this->cinemaId;
    }

    public function setCinemaId($cinemaId)
    {
        $this->cinemaId = $cinemaId;
    }

    public function getPrice()
    {
        return $this->price;
    }


    public function setPrice($price)
    {
        $this->price = $price;
    }
}
