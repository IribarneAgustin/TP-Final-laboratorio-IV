<?php
namespace DAO;

use Models\Cinema as Cinema;

interface ICinemaDAO{
    
    function add($cinema);
    function getAll();
    function remove($cinemaId);
    function update(Cinema $modifiedCinema);

}