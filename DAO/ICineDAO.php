<?php
namespace DAO;

use Models\Cine;

interface ICineDAO{
    function add($cine);
    function getAll();

}