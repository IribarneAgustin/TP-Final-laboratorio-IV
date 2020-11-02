<?php

namespace DAO;

use Models\User;


class UserDAO implements IUserDAO
{

    private $connection;
    private $tableName = "user";

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function add(User $user)
    {
        try {

            $sql = "INSERT INTO user (username, email, password, role) VALUES (:username, :email, :password, :role)";
            $parameters['username'] = $object->getUsername();
            $parameters['email'] = $object->getEmail();
            $parameters['password'] = $object->getPassword();
            $parameters['role'] = $object->getRole();
            $this->connection->execute("nonQuery", $query, $parameters);

        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
    
    public function getByUsername($username)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE " . $this->tableName . ".username ='$username'";

            $resultSet = $this->connection->execute('query', $query);
            $user = NULL;
            foreach ($resultSet as $row) {

                $user = new User();
                $user->setId($row["id"]);
                $user->setUsername($row["username"]);
                $user->setEmail($row["email"]);
                $user->setPassword($row["password"]);
                $user->setRole($row["role"]);
            }
            return $user;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    
    }

    public function getByEmail($email)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE " . $this->tableName . ".email ='$email'";

            $resultSet = $this->connection->execute('query', $query);
            $user = NULL;
            foreach ($resultSet as $row) {

                $user = new User();
                $user->setId($row["id"]);
                $user->setUsername($row["username"]);
                $user->setEmail($row["email"]);
                $user->setPassword($row["password"]);
                $user->setRole($row["role"]);
            }
            return $user;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getAll()
    {
        try {
            $cinemaList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute('query', $query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $user = new User();
                    $user->setId($row["id"]);
                    $user->setUsername($row["username"]);
                    $user->setEmail($row["email"]);
                    $user->setPassword($row["password"]);
                    $user->setRole($row["role"]);

                    array_push($userList, $user);
                }
            }

            return $userList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function update($modifiedUser){

        try {
            
            $id = $modifiedUser->getId();
            $username = $modifiedUser->getUsername();
            $email = $modifiedUser->getEmail();
            $password = $modifiedUser->getPassword();
            $role = $modifiedUser->getRole();

            $query = "UPDATE $this->tableName SET username='$username',email= '$email',password= '$password', role='$role' WHERE id='$id'";
            $this->connection->execute('nonQuery', $query);
        } catch (\PDOException $ex) {
            throw $ex;
        }

    }

    public function remove($userId)
    {

    }

    public function existsUser($username, $email)
    {
        $exists = false;
        try {
            $query = "SELECT * FROM user WHERE user.username ='$username' AND user.email ='$email'";
            $resultSet = $this->connection->execute('query',$query);
            if (!empty($resultSet)) {
                $exists = true;
            }
            return $exists;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}