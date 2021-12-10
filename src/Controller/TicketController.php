<?php

namespace App\Controller;

require_once(__DIR__.'/../Model/TicketModel.php');

use App\Model\TicketModel;

class TicketController {

    public function getTickets()
    {
        $ticketModel = new TicketModel;
        $tickets = $ticketModel->findBy(array(""))
    }
}