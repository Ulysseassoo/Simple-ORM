<?php

namespace App\Model;

use Framework\Model;
use \PDO;

class TicketModel extends Model
{
    public function findAll(): Array
    {
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM `ticket`');
        $query->execute();
        $tickets =  $query->fetchAll(PDO::FETCH_ASSOC);
        return $tickets;
    }

    public function find(Int $id)
    {
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM `ticket` WHERE id = :id');
        $query->execute([
            "id" => $id
        ]);
        $ticket = $query->fetch(PDO::FETCH_ASSOC);
        return ($ticket);
    }

    public function findBy(array $criteria, array $orderBy = null): Array
    {
        dd($criteria);
        $db = $this->getDb();
        $query = $db->prepare("SELECT * FROM `ticket` WHERE :criteria = :criteria_value");
        $query->execute([
            "criteria" => $criteria[0],
            "criteria_value" => $criteria[1]
        ]);
        $tickets = $query->fetchAll(PDO::FETCH_ASSOC);
        return ($tickets);
    }
}