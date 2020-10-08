<?php
namespace DAO;

use Models\Cinema;

interface ICinemaDAO{
    
    function add($cinema);
    function getAll();
    function remove($cinemaId);

}