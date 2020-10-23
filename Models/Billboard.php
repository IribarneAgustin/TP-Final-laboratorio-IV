<?php

namespace Models;

class Billboard{

    private $initDate;
    private $finishDate;
    private $movies;

    public function __construct()
    {
        
    }

    public function getInitDate()
    {
        return $this->initDate;
    }

    public function setInitDate($initDate)
    {
        $this->initDate = $initDate;

    }

    public function getFinishDate()
    {
        return $this->finishDate;
    }


    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;

    }


    public function getMovies()
    {
        return $this->movies;
    }


    public function setMovies($movies)
    {
        $this->movies = $movies;

    }
}