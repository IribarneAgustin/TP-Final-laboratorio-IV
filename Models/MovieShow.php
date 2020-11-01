<?php

namespace Models;

class MovieShow
{
    private $id;
    private $date;
    private $time;
    private $ticketsSold;
    private $room;
    private $movie;
    private $status;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTicketsSold()
    {
        return $this->ticketsSold;
    }

    public function setTicketsSold($ticketsSold)
    {
        $this->ticketsSold = $ticketsSold;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getRoom()
    {
        return $this->room;
    }

 
    public function setRoom(Room $room)
    {
        $this->room = $room;
    }

    public function getMovie()
    {
        return $this->movie;
    }

    public function setMovie(Movie $movie)
    {
        $this->movie = $movie;
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
