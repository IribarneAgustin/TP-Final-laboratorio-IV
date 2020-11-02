<?php
    namespace DAO;

    use Models\User;

    interface IUserDAO{
    
        function add(User $user);
        function getAll();
        function remove($userId);
        function update(User $modifiedUser);

}