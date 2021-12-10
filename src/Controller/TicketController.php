<?php

namespace App\Controller;

require_once(__DIR__.'/../Model/TicketModel.php');

use App\Model\TicketModel;

class TicketController {

    public function getTickets(): string
    {   
        $ticketModel = new TicketModel;
        $tickets = $ticketModel->findBy(array("section" => "Marketing"));
        header('Content-Type: application/json');
        if($tickets){
            $response = [
                "status" => 200,
                "data" => $tickets
            ];
        } else {
            $response = [
                "status" => 404,
                "message" => "There are no tickets."
            ];
        }
        echo(json_encode($response));
        return json_encode($response);
    }

    public function getAll():string
    {   
        $ticketModel = new TicketModel;
        $tickets = $ticketModel->findAll();
        header('Content-Type: application/json');
        if($tickets){
            $response = [
                "status" => 200,
                "data" => $tickets
            ];
        } else {
            $response = [
                "status" => 404,
                "message" => "There are no tickets."
            ];
        }
        echo(json_encode($response));
        return json_encode($response);
    }

    public function getTicket(Int $id): string
    {   
        $ticketModel = new TicketModel;
        $ticket = $ticketModel->find($id);
        header('Content-Type: application/json');
        if($ticket){
            $response = [
                "status" => 200,
                "data" => $ticket
            ];
        } else {
            $response = [
                "status" => 404,
                "message" => "There are no ticket."
            ];
        }
        echo(json_encode($response));
        return json_encode($response);
    }

    public function createTicket(): void
    {
        $ticketModel = new TicketModel();

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $errors = [];
        if(empty($data->title) || $data->title === ""){
            $errors[] = "title cannot be null";
        }
        if(empty($data->section) || $data->section === ""){
            $errors[] = "section cannot be null";
        }
        if(empty($data->description) || $data->description === null || $data->description === ""){
            $errors[] = "description cannot be null";
        }

        
        header('Content-Type: application/json');
        if (sizeOf($errors) === 0) {
            $ticket = $ticketModel->save($data->section, $data->title, $data->description);
            if ($ticket){
                $result = [
                    "status" => 201,
                    "result" => "ticket created !"
                ];
            }
        }
        else {
            $result = [
                "status" => 400,
                "details" => $errors
            ];
        }
        echo(json_encode($result));
    }

    public function export(Int $ticket_id): void
    {
        $ticketModel = new TicketModel();
        $ticket = $ticketModel->getComments($ticket_id);
        $ticket_text = "Ticket id #{$ticket[0]['id']}\r Section : {$ticket[0]['section']}\rTitle : {$ticket[0]['title']}\rDescription : {$ticket[0]['description']}\rCreated at : {$ticket[0]['createdAt']}\rState : {$ticket[0]['state']}\r\rAll comments \r\r";
        $my_file = fopen(__DIR__."/../Data/trame.txt", "w", true);
        fwrite($my_file, $ticket_text);

        foreach ($ticket[1] as $comment) {
            $comment = "comment#{$comment["id"]}\rdescription : {$comment["description"]}\rcreatedAt : {$comment["createdAt"]}\r\r";
            fwrite($my_file, $comment);
        }
        
        fclose($my_file);
        header('Content-Type: application/json');
        echo(json_encode("Ticket has been exported"));
    }
}