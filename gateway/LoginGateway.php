<?php

namespace druppaApi\Gateway;

use mysqli_sql_exception;

class LoginGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }



    public function find($input)
    {
        $statement = "
            SELECT 
                *
            FROM
                users
            WHERE email=? AND password=?;
        ";

        try {
            $email = $input['email'];
            $password = $input['password'];

            $statement = $this->db->prepare($statement);
            $statement->bind_param("ss", $email, $password);

            $statement->execute();
            $result =
                $result = $statement->get_result()->fetch_assoc();

            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input)
    {
        $statement = "
            INSERT INTO users 
                (first_name, last_name,email,password)
            VALUES
                (?, ? ,?, ?)
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bind_param("ssss", $input['first_name'], $input['last_name'], $input['email'], $input['password']);
            $statement->execute();

            $insertedUserId = $statement->insert_id;

            $selectStatement = "SELECT * FROM users WHERE id = ?";
            $selectStatement = $this->db->prepare($selectStatement);
            $selectStatement->bind_param("i", $insertedUserId);
            $selectStatement->execute();

            $result = $selectStatement->get_result();
            $insertedUser = $result->fetch_assoc();

            return $insertedUser;
        } catch (\mysqli_sql_exception $err) {
            if ($err->getCode() === 1062 && strpos($err->getMessage(), 'users_email_unique') !== false) {
                return  'Email already exists';
            } else {
                exit($err->getMessage());
            }
        }
    }


    public function update($id, array $input)
    {
        $statement = "
            UPDATE users
            SET 
                first_name = :first_name,
                last_name  = :last_name,
                email = :email,
                password = :password
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'first_name' => $input['first_name'],
                'last_name'  => $input['last_name'],
                'email' => $input['email'],
                'password' => $input['password'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
