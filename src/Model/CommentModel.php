<?php

    namespace App\Model;

    use Framework\Model;
    use \PDO;

    class CommentModel extends Model{

        public function findAll():Array
        {
            $db = $this->getDb();
            $query = $db->prepare('SELECT * FROM `comment`');
            $query->execute();
            $comments = $query->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        }

        public function find(Int $id): Array
        {

            $response = [];

            $db = $this->getDb();
            $query = $db->prepare('SELECT * FROM `ticket_has_comment` WHERE ticket_id = :ticket_id');
            $query->execute([
                "ticket_id" => $id
            ]);
            $comments_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach($comments_ids as $comment_id) {
                $query = $db->prepare('SELECT * FROM `comment` WHERE id = :comment_id');
                $query->execute([
                    "comment_id" => $comment_id["comment_id"]
                ]);
                $comments = $query->fetch(PDO::FETCH_ASSOC);
                array_push( $response , $comments);
            }
            return $response;
        }

        // Only one criteria
        public function findBy(array $criteria): Array
        {
            $value = array_values($criteria)[0];
            $key = array_keys($criteria)[0];
            $db = $this->getDb();
            $query = $db->prepare("SELECT * FROM `comment` WHERE $key = :criteria_value");
            $query->execute([
                "criteria_value" => "$value"
            ]);
            $comments = $query->fetchAll(PDO::FETCH_ASSOC);
            return ($comments);
        }

        public function save($description, $ticket_id): Array|bool
        {

            $createdAt = date("Y/m/d H:i:s");

            $db = $this->getDb();
            $query = $db->prepare('SELECT * FROM `ticket` WHERE id = :ticket_id');
            $query->execute([
                "ticket_id" => $ticket_id
            ]);
            $current_ticket = $query->fetch(PDO::FETCH_ASSOC);

            if($current_ticket){

                $query = $db->prepare('INSERT INTO `comment`(`description`, `createdAt`) VALUES (:description,:createdAt)');
                $query->execute([
                    "description" => $description,
                    "createdAt" => $createdAt
                ]);
    
                $query = $db->prepare('SELECT * FROM `comment` WHERE createdAt = :created_at');
                $query->execute([
                    "created_at" => $createdAt
                ]);
    
                $current_comment = $query->fetch(PDO::FETCH_ASSOC);
    
                $query = $db->prepare('INSERT INTO `ticket_has_comment`(`comment_id`, `ticket_id`) VALUES (:comment_id, :ticket_id)');
                $query->execute([
                    "comment_id" => $current_comment["id"],
                    "ticket_id" => $ticket_id
                ]);
                return [
                    $current_ticket,
                    $current_comment
                ];
            } else {

                return false;

            }
        }

    }

?>