<?php

namespace DAO;

use \PDO as PDO;
use \Exception as Exception;
use DAO\QueryType as QueryType;

class Connection
{

    private $pdo;
    private $pdoStatement;
    private static $instance;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new Connection();

        return self::$instance;
    }

    public function prepare($query)
    {
        try {
            $this->pdoStatement = $this->pdo->prepare($query);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function bindParameters($parameters, $queryType = QueryType::Query){
        
        $i = 0; 

        if(is_array($parameters)){

            foreach($parameters as $parameterName => $value)
            {                
                $i++;

                if($queryType == QueryType::Query)
                    $this->pdoStatement->bindParam(":".$parameterName, $parameters[$parameterName]);
                else
                    $this->pdoStatement->bindParam($i, $parameters[$parameterName]);
            }
        }
    }

    public function execute($executeType,$query, $parameters = array(), $queryType = QueryType::Query)
    {
        try {

            $this->prepare($query);

            $this->bindParameters($parameters, $queryType);

            $this->pdoStatement->execute();
           
           
            if($executeType == 'nonQuery'){
                $response = $this->pdoStatement->rowCount();
            }else if($executeType == 'query'){
                $response = $this->pdoStatement->fetchAll();
            }
            
            return $response;

        } catch (Exception $ex) {

            throw $ex;
        }
    }


    //Retorna la cantidad de registros modificados (sirve para saber si se realizo una tarea)

    public function executeNonQuery($query, $parameters = array(), $queryType = QueryType::Query)
    {            
        try
        {
            $this->prepare($query);
            
            $this->bindParameters($parameters, $queryType);

            $this->pdoStatement->execute();

            return $this->pdoStatement->rowCount();
        }
        catch(Exception $ex)
        {
            throw $ex;
        }        	    	
    }




}




