<?php

namespace App\Controller;

require_once(__DIR__.'/../Model/TicketModel.php');

use App\Model\TicketModel;

class TicketController {

    public function getTickets()
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
                "status" => 301,
                "message" => "There are no tickets."
            ];
        }
        echo(json_encode($response));
        return json_encode($response);
    }

    public function getAll()
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
                "status" => 301,
                "message" => "There are no tickets."
            ];
        }
        echo(json_encode($response));
        return json_encode($response);
    }

    public function getTicket(Int $id)
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
                "status" => 301,
                "message" => "There are no ticket."
            ];
        }
        echo(json_encode($response));
        return json_encode($response);
    }

    public function createTicket()
    {
        $ticketModel = new TicketModel();

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $ticket = $ticketModel->save($data->section, $data->title, $data->description);
        header('Content-Type: application/json');
        
        if ($ticket){
            $result = [
                "status" => 200,
                "result" => "ticket created !"
            ];
        } else {
            $result = [
                "status" => 400,
                "result" => "problem occured!"
            ];
        }
        echo(json_encode($result));
        return $ticket;
    }
}