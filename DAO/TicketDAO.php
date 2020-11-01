<?php

namespace DAO;

use Models\Ticket;
use Models\User;


class TicketDAO implements ITicketDAO
{

    private $connection;
    private $tableName = "ticket";

    public function __construct()
    {
        $this->connection = new Connection();
    }


    public function add(Ticket $ticket)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (idUser, idMovieShow, quantity, total) VALUES (:idUser, :idMovieShow, :quantity, :total);";

            $parameters["idUser"] = $ticket->getUser()->getDni();
            $parameters["idMovieShow"] = $ticket->getMovieShow()->getId();
            $parameters["quantity"] = $ticket->getQuantity();
            $parameters["total"] = $ticket->getTotal();

            $this->connection->execute("nonQuery", $query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}
