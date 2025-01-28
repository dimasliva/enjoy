<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/models/Database.php");

// interface UserInterface
// {
//     public function getID(): int;
//     public function getName(): string;
//     public function getRole(): string;
//     public function login(string $name, string $password): array;
// }

class User
    // class User implements UserInterface
{
    private $conn;
    private $id;
    private $name;
    private $role;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function getID()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function login($name, $password)
    {
        $sql = "SELECT * FROM users WHERE name=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if ($password == $row['password']) {
                return [
                    "success" => true,
                    "data" => [
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'password' => $row['password'],
                        'role' => $row['role'],
                    ]
                ];
            }
        }

        return [
            "success" => false,
            "data" => [],
        ];
    }
}
