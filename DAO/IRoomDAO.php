<?php 
    namespace DAO;

    use Models\Room as Room;
    use Models\Cinema;

    interface IRoomDAO
    {
        function add(Room $room, Cinema $cinema);
        function getAll();
        function remove($idRoom);
        function update(Room $modifiedRoom);
    }
?>