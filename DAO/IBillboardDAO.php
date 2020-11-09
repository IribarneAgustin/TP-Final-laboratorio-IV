<?php
namespace DAO;
use Models\Cinema;
use Models\Room;
use Models\Movie;

interface IBillboardDAO{

    public function add(Movie $movie, Cinema $cinema);


}