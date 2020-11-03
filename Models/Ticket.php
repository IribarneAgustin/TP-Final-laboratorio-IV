<?php

namespace Models;

class Ticket
{
    private $id;
    private $quantity;
    private $total;
    private $user;
    private $movieShow;
    private $status;

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

    public function getQuantity()
    {
        return $this->quantity;
    }


    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;

    }

    public function getMovieShow()
    {
        return $this->movieShow;
    }

    public function setMovieShow($movieShow)
    {
        $this->movieShow = $movieShow;

    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

    }

 
    public function getStatus()
    {
        return $this->status;
    }
 
    public function setStatus($status)
    {
        $this->status = $status;

    }
}