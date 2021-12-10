<?php 

namespace App\Controller;

require_once(__DIR__.'/../Model/CommentModel.php');

use App\Model\CommentModel;

class CommentController {

    public function getComments()
    {
        $allComments = new CommentModel();
        $comments = $allComments->findAll();
        header('Content-Type: application/json');

        if($comments){
            $response = [
                "status" => 200,
                "result" => $comments
            ];
        } else {
            $response = [
                "status" => 404,
                "message" => "No comment !"
            ];
        }
        echo(json_encode($response));
        return json_encode($response);
    }
    public function getComment(Int $id)
    {
        $commentModel = new CommentModel();
        $comments = $commentModel->find($id);
        header('Content-Type: application/json');

        if($comments){
            $response = [
                "status" => 200,
                "result" => $comments
            ];
        } else {
            $response = [
                "status" => 404,
                "message" => "No comment for this ticket !"
            ];
        }
        echo(json_encode($response));
        return json_encode($response);
    }
    public function createComment(Int $ticket_id)
    {
        $commentModel = new CommentModel();

        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $comment = $commentModel->save($data->description, $ticket_id);
        header('Content-Type: application/json');

        if($comment){
            $response = [
                "status" => 201,
                "results" => $comment
            ];
        } else {
            $response = [
                "status" => 404,
                "results" => "This ticket doesn't exist"
            ];
        }
        echo(json_encode($response));
        return json_encode($comment);
    }
}

?>