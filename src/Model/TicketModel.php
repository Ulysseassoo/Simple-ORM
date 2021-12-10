<?php

namespace App\Model;

use Framework\Model;
use \PDO;

require_once(__DIR__.'/../Framework/Model.php');

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

    // Only one criteria
    public function findBy(array $criteria): Array
    {
        $value = array_values($criteria)[0];
        $key = array_keys($criteria)[0];
        $db = $this->getDb();
        $query = $db->prepare("SELECT * FROM `ticket` WHERE $key = :criteria_value");
        $query->execute([
            "criteria_value" => "$value"
        ]);
        $tickets = $query->fetchAll(PDO::FETCH_ASSOC);
        return ($tickets);
    }

    public function save($section, $title, $description){

        $createdAt = date("Y/m/d H:i:s");
        $intial_state = "En cours";

        $db = $this->getDb();
        $query = $db->prepare('INSERT INTO `ticket`(`section`, `title`, `description`, `createdAt`, `state`) VALUES (:section,:title,:description,:createdAt,:state)');
        $query->execute([
            "section" => $section,
            "title" => $title,
            "description" => $description,
            "createdAt" => $createdAt,
            "state" => $intial_state
        ]);

        return true;
    }

    public function getComments($ticket_id){
        $db = $this->getDb();
        $query = $db->prepare('SELECT * FROM `ticket` WHERE id = :ticket_id');
        $query->execute([
            "ticket_id" => $ticket_id
        ]);
        $ticket = $query->fetch(PDO::FETCH_ASSOC);

        if($ticket){
            $query = $db->prepare('SELECT * FROM `ticket_has_comment` WHERE ticket_id = :ticket_id');
            $query->execute([
                "ticket_id" => $ticket_id
            ]);
            $comments_id = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        $result = [];

        foreach ($comments_id as $comment) {
            $query = $db->prepare('SELECT * FROM `comment` WHERE id = :comment_id');
            $query->execute([
                "comment_id" => $comment["comment_id"]
            ]);
            $comment = $query->fetch(PDO::FETCH_ASSOC);
            array_push($result, $comment);
        }

        $data = [
            $ticket,
            $result
        ];
        return $data;
    }
}