<?php
namespace DAO;
use Models\Cinema;
use Models\Room;

interface IBillboardDAO{

    public function add(Movie $movie, Cinema $cinema);


}