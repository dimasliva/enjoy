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
        if (!isset($_SESSION['loginAttempts'])) {
            $_SESSION['loginAttempts'] = 0;
        }
        if (!isset($_SESSION['blockTime'])) {
            $_SESSION['blockTime'] = 0;
        }
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
    public function getLoginAttempts()
    {
        return $_SESSION['loginAttempts'];
    }
    public function register( $name,  $password,  $role)
    {
        $sql = "SELECT * FROM users WHERE name=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return [
                "success" => false,
                "message" => "Пользователь с таким именем уже существует."
            ];
        }
    
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        $sql = "INSERT INTO users (name, password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $name, $hashedPassword, $role);
    
        if ($stmt->execute()) {
            $newUserId = $stmt->insert_id;
            $stmt->close();
    
            return [
                "success" => true,
                "data" => [
                    'id' => $newUserId,
                    'name' => $name,
                    'role' => $role,
                ],
                "message" => "Регистрация прошла успешно."
            ];
        } else {
            return [
                "success" => false,
                "message" => "Ошибка при регистрации: " . $stmt->error
            ];
        }
    }
    
    public function login($name, $password)
    {
        if ($this->isBlocked()) {
            return [
                "success" => false,
                "message" => "Вы заблокированы. Пожалуйста, подождите 5 минут."
            ];
        }

        $sql = "SELECT * FROM users WHERE name=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $this->resetLoginAttempts();
                return [
                    "success" => true,
                    "data" => [
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'role' => $row['role'],
                    ]
                ];
            }
        }

        $this->incrementLoginAttempts();
        return [
            "success" => false,
            "data" => [],
            "message" => "Неверное имя пользователя или пароль."
        ];
    }

    private function isBlocked()
    {
        return $_SESSION['loginAttempts'] >= 3 && (time() < $_SESSION['blockTime']);
    }

    private function incrementLoginAttempts()
    {
        $_SESSION['loginAttempts']++;
        if ($_SESSION['loginAttempts'] >= 3) {
            $_SESSION['blockTime'] = time() + 300; 
        }
    }

    private function resetLoginAttempts()
    {
        $_SESSION['loginAttempts'] = 0;
        $_SESSION['blockTime'] = 0;
    }
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $stmt->close();
        return $users;
    }

    public function updateUser($id, $name, $role) {
        $sql = "UPDATE users SET name=?, role=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $role, $id);
        if($stmt->execute()){
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        
        if($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

}
