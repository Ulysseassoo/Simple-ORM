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
                "message" => "No comments found"
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

        $errors = [];
        if(empty($data->description) || $data->description === null || $data->description === ""){
            $errors[] = "description cannot be null";
        }
        
        header('Content-Type: application/json');
        if (sizeOf($errors) === 0) {
            $comment = $commentModel->save($data->description, $ticket_id);
            if ($comment){
                $response = [
                    "status" => 201,
                    "result" => "ticket created !"
                ];
            }
        }
        else {
            $response = [
                "status" => 400,
                "details" => $errors
            ];
        }
        echo(json_encode($response));
        return json_encode($comment);
    }
}

?>