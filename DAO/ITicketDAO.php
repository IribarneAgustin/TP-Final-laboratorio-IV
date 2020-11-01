<?php 
    namespace DAO;

    use Models\Ticket;

    interface ITicketDAO
    {
        function add(Ticket $ticket);
     //   function getAll();
    //  function remove($idTicket);
     //   function update(Ticket $modifiedTicket);
    }
?>