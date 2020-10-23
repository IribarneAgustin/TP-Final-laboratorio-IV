<?php
    namespace DAO;

    use \PDO as PDO;
    use \Exception as Exception;
    use DAO\QueryType as QueryType;

    class Connection
    {
        private $pdo = null;
        private $pdoStatement = null;
        private static $instance = null;

        private function __construct()
        {
            try
            {
                $this->pdo = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME, DB_USER, DB_PASS);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public static function getInstance()
        {
            if(self::$instance == null)
                self::$instance = new Connection();

            return self::$instance;
        }

        

        public function execute($executeType, $query, $parameters = array(), $queryType = QueryType::Query) {
            
            $response = null;
            try{
                $this->prepare($query);                
                $this->bindParameters($parameters, $queryType);                
                $this->pdoStatement->execute();

                if($executeType == 'nonQuery'){
                    $response = $this->pdoStatement->rowCount();
                }else if($executeType == 'query'){
    	            $response = $this->pdoStatement->fetchAll();
                }

                return $response;
            } catch(Exception $ex) {
                throw $ex;
            }

        }

        
        private function prepare($query)
        {
            try
            {
                $this->pdoStatement = $this->pdo->prepare($query);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }
        
        private function bindParameters($parameters = array(), $queryType = QueryType::Query){
            
            $i = 0;
            foreach($parameters as $parameterName => $value){                
                $i++;
                if($queryType == QueryType::Query)
                    $this->pdoStatement->bindParam(":".$parameterName, $value);
                else
                    $this->pdoStatement->bindParam($i, $value);
            }
        }
    }
?>

