<?php 
    namespace DAO;

    use Models\Room as Room;

    interface IRoomDAO
    {
        function Add(Room $room);
        function GetAll();
        function Remove($idRoom);
        function Update(Room $modifiedRoom);
    }
?>