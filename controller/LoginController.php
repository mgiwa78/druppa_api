<?php

namespace druppaApi\Controller;


require "gateway/LoginGateway.php";

use druppaApi\Gateway\LoginGateway;
use Firebase\JWT\JWT;

$secretKey = getenv("DRUPPA_SECRET");


class LoginController
{

    private $db;
    private $requestMethod;

    private $loginGateway;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->loginGateway = new LoginGateway($db);
    }

    public function processRequest()
    {

        switch ($this->requestMethod) {

            case 'POST':
                $response = $this->getUser();
                break;
            default:
                header("Content-Type: application/json");
                header("HTTP/1.1 404 Not Found");

                $data = array(
                    "message" => "error",
                    "body" => array(
                        "error" => "Invalid Request"
                    )
                );
                $response = $data;
                break;
        }
        if (header(isset($response['status_code_header']))) {
            header($response['status_code_header']);
        };
        if (isset($response['body'])) {
            echo json_encode($response['body']);
        }
    }

    private function getUser()
    {

        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateData($input)) {
            return $this->unprocessableEntityResponse();
        }
        $result = $this->loginGateway->find($input);
        if (!$result) {
            header("HTTP/1.1 404 Not Found");

            $response["body"] = $this->notFoundResponse()["body"];

            return $response;
            if (isset($response['body'])) {
            } else {
            }
        }

        if ($result) {
            $secretKey = getenv("DRUPPA_SECRET");

            $payload = [
                'email' => $result["email"],
            ];

            $jsonToken = JWT::encode($payload, $secretKey, 'HS256');
            $data = ["userCredentials" => $result, "jwt" => $jsonToken];
            $response['LoginToken'] = $jsonToken;
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = $data;
        }
        return $response;
    }

    private function validateData($input)
    {
        if (!isset($input['email'])) {
            return false;
        }
        if (!isset($input['password'])) {
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
        $response['body'] = [
            'error' => 'Invalid User'
        ];
        return $response;
    }
}
