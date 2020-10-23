<?php
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\Connection as Connection;

    class CinemaDAODB implements ICinemaDAO
    {
        private $connection;
        private $tableName = "cinema";

        public function add(Cinema $cinema)
        {
            try
            {
                $query = "INSERT INTO ".$this->tableName." (id, name, capacity, address, ticketPrice) VALUES (:id, :name, :capacity, :address, :ticketPrice);";
                
                $parameters["id"] = $cinema->getId();
                $parameters["name"] = $cinema->getName();
                $parameters["capacity"] = $cinema->getCapacity();
                $parameters["address"] = $cinema->getAddress();
                $parameters["ticketPrice"] = $cinema->getTicketPrice();

                $this->connection = Connection::getInstance();

                $this->connection->execute('nonQuery',$query, $parameters);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }



        public function update(Cinema $modifiedCinema)
        {
            try{

                $query = "UPDATE ". $this->tableName ." SET cinemaName='$modifiedCinema->getName()', capacity='$modifiedCinema->getCapacity()'"  . " WHERE idCinema ='$modifiedCinema->getId()'";
                $this->connection = Connection::getInstance();
                $this->connection->execute('nonQuery',$query);
                }
                catch(Exception $ex){
                    throw $ex;
                }
        }
           
        public function remove($cinemaId)
        {   
            try
            {
            $query = "DELETE FROM ". $this->tableName . " WHERE ". $this->tableName . ".id ='$cinemaId'";
                $this->connection = Connection::getInstance();
                $this->connection->execute('nonQuery',$query);
            }
            catch(Exception $ex)
            {
               throw $ex;
            }
        }    

        public function getAll()
        {
            try
            {
                $cinemaList = array();

                $query = "SELECT * FROM ".$this->tableName;
                
                
                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute('query',$query);

                if(!empty($resultSet)){
                    foreach ($resultSet as $row)
                    {               
                    
                        $cinema = new Cinema();
                        $cinema->setId($row["id"]);
                        $cinema->setName($row["name"]);
                        $cinema->setCapacity($row["capacity"]);
                        $cinema->setAddress($row["address"]);
                        $cinema->setTicketPrice($row["ticketPrice"]);

                        array_push($cinemaList, $cinema);
                    }
                }

                return $cinemaList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }
 
              

        public function getById($idCinema){
            try
            {
            $query = "SELECT * FROM ".$this->tableName. " WHERE ". $this->tableName .".id ='$idCinema'";
            $this->connection = Connection::getInstance();
            $resultSet = $this->connection->execute('query',$query);
            $cinema=NULL;
            foreach ($resultSet as $row){
                
                $cinema = new Cinema();
                    $cinema->setId($row["id"]);
                    $cinema->setName($row["name"]);
                    $cinema->setCapacity($row["capacity"]);
                    $cinema->setAddress($row["address"]);
                    $cinema->setTicketPrice($row["ticketPrice"]);
                
            }
            return $cinema;
            }
            catch(Exception $ex)
            {
               throw $ex;
            }
        }


    public function existsName($name)
    {
        $exists = false;

        try
        {
        $query = "SELECT * FROM ".$this->tableName. " WHERE ". $this->tableName .".name ='$name'";
        $this->connection = Connection::getInstance();
        $resultSet = $this->connection->execute('query',$query);
        
        if(!empty($resultSet)){
            $exists = true;
        }
        return $exists;
        }
        catch(Exception $ex)
        {
           throw $ex;
        }
        
        
    }
    }
?>