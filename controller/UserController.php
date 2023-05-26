<?php

namespace druppaApi\Controller;

require "gateway/UserGateway.php";

use druppaApi\Gateway\UserGateway;

class UserController
{

    private $db;
    private $requestMethod;
    private $userId;

    private $personGateway;

    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->personGateway = new UserGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getUser($this->userId);
                } else {
                    $response = $this->getAllUsers();
                };
                break;
            case 'POST':
                $response = $this->updateUserFromRequest($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteUser($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);

        if (isset($response['body'])) {
            echo json_encode($response['body']);
        } else {
            $errors = [
                'error' => $response['error']
            ];
            echo json_encode($errors);
        }
    }

    private function getAllUsers()
    {
        $result = $this->personGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getUser($id)
    {
        $result = $this->personGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }



    private function updateUserFromRequest($id)
    {
        $result = $this->personGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }

        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        $result = $this->personGateway->update($id, $input);
        if ($result["status"]) {


            $data = ["userCredentials" => $result];


            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = $data;
        } elseif (!$result["status"] && $result["data"] === "Email already exists") {

            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $data = ["error_code" => 'HTTP/1.1 400 Bad Request', "error_message" => $result["data"]];

            $response["body"] = $data;
        }
        return $response;
    }

    private function deleteUser($id)
    {
        $result = $this->personGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $this->personGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validatePerson($input)
    {
        if (!isset($input['first_name'])) {
            return false;
        }
        if (!isset($input['last_name'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
