<?php

namespace druppaApi\Gateway;


class UserGateway
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                id, first_name, last_name
            FROM
                users;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetch_assoc();
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
            SELECT 
                *
            FROM
                users
            WHERE id = ?;
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
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
                (first_name, last_name, firstparent_id, secondparent_id)
            VALUES
                (:first_name, :last_name, :firstparent_id, :secondparent_id);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'first_name' => $input['first_name'],
                'last_name'  => $input['last_name'],
                'firstparent_id' => $input['firstparent_id'] ?? null,
                'secondparent_id' => $input['secondparent_id'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input)
    {
        $statement = "
            UPDATE users
            SET 
                first_name = ?,
                last_name  = ?,
                email = ?,
                phone = ?
            WHERE id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bind_param(
                "ssssi",
                $input['first_name'],
                $input['last_name'],
                $input['email'],
                $input['phone'],
                $id
            );
            $statement->execute();
            $udatedUser = $this->find($id);



            return ["status" => true, "data" => $udatedUser];
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM users
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
