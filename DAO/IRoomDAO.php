<?php 
    namespace DAO;

    use Models\Room as Room;

    interface IRoomDAO
    {
        function add(Room $room);
        function getAll();
        function remove($idRoom);
        function update(Room $modifiedRoom);
    }
?>