<?php
namespace DAO;

use Models\MovieShow as MovieShow;

interface IMovieShowDAO{
    
    function add(MovieShow $movieShow,$roomId,$movieId);
    function getAll();
    function remove($movieShowId);
    function update(MovieShow $modifiedMovieShow);

}