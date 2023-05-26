<?php

namespace druppaApi\Controller;


require "gateway/SignUpGateway.php";

use druppaApi\Gateway\SignUpGateway;
use Firebase\JWT\JWT;

$secretKey = getenv("DRUPPA_SECRET");


class SignUpController
{
    private $db;
    private $requestMethod;

    private $authGateway;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->authGateway = new SignUpGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->createUserFromRequest();
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

    private function createUserFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateNewUser($input)) {
            return $this->unprocessableEntityResponse();
        }
        $result = $this->authGateway->insert($input);
        if ($result["status"]) {
            $secretKey = getenv("DRUPPA_SECRET");

            $payload = [
                'email' => $input["email"],
            ];

            $jsonToken = JWT::encode($payload, $secretKey, 'HS256');
            $data = ["userCredentials" => $result, "jwt" => $jsonToken];


            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = $data;
        } elseif (!$result["status"] && $result["data"] === "Email already exists") {
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $data = ["error_code" => 'HTTP/1.1 400 Bad Request', "error_message" => $result["data"]];

            $response["body"] = $data;
        }

        return $response;
    }

    private function validateNewUser($input)
    {
        if (!isset($input['email'])) {
            return false;
        }
        if (!isset($input['password'])) {
            return false;
        }
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

    // private function notFoundResponse()
    // {
    //     $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    //     $response['body'] = null;
    //     return $response;
    // }
}
