<?php 
namespace DAO;
use Models\Billboard;

class BillboardDAOMySQL implements IBillboardDAO
{
    private $connection;
    private $tableName = "billboard";

    public function __construct()
    {
        $this->connection = new Connection();
    }
    public function add(Billboard $billboard)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (name, status) VALUES (:name, :status);";

            $parameters["name"] = $billboard->getName();
            $parameters["status"] = $billboard->getStatus();
            
            $this->connection->execute("nonQuery",$query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getAll(){
        try {
            $billboardList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute('query',$query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $billboard = new Billboard();
                    $billboard->setId($row["idBillboard"]);
                    $billboard->setName($row["name"]);
                    $billboard->setStatus($row["status"]);
                    array_push($billboardList, $billboard);
                }
            }

            return $billboardList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getById($idBillboard)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE " . "id$this->tableName  ='$idBillboard'";

            $resultSet = $this->connection->execute('query',$query);
            $billboard = NULL;
            foreach ($resultSet as $row) {

                $billboard = new Billboard();
                $billboard->setId($row["idBillboard"]);
                $billboard->setName($row["name"]);
                $billboard->setStatus($row["status"]);
            }
            return $billboard;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }




}