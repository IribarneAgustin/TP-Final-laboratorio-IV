<?php 
    namespace Models;

    class Room
    {
        private $id;
        private $Name;
        private $capacity;

        public function getId()
        {
            return $this->idRoom;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function getCapacity()
        {
            return $this->capacity;
        }

        public function setCapacity($capacity)
        {
            $this->capacity = $capacity;
        }
    }
?>