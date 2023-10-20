<?php
namespace App\Models;

use App\Models\Database;
use DateTime;
use PDO;
use PDOException;

class User
{
	protected int $id;

	protected string $name;

	protected string $email;

    protected string $password;

    protected DateTime $created_at;

    protected ?DateTime $updated_at = null;

    public function getId(): int
    {
		return $this->id;
	}

	public function getName(): string
    {
		return $this->name;
	}

	public function getEmail(): string
    {
		return $this->email;
	}

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setName(string $name): self
    {
		$this->name = $name;

        return $this;
	}

	public function setEmail(string $email): self
    {
		$this->email = $email;

        return $this;

    }

    public function setPassword(string $password): static
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->created_at = $createdAt;

        return $this;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public static function getCurrentUser(): ?User
    {
        session_start();

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            return self::getUserById($userId);
        }
        return null;
    }

    public function update(): void
    {
        $db = Database::getInstance();

        $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $params = [
            ':id' => $this->id,
            ':name' => $this->name,
            ':email' => $this->email
        ];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }


    public function create(): void
    {
        $db = Database::getInstance();

        $sql = "INSERT INTO users (name, email, password, created_at, updated_at) 
                VALUES (:name, :email, :password, NOW(), NOW())";
        $params = [
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => $this->password
        ];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            $this->id = $db->getConnection()->lastInsertId();
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getUserByEmail(string $email): ?User
    {
        $db = Database::getInstance();
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->getConnection()->prepare($sql);
        $stmt->execute([':email' => $email]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User();
            $user->id = $result['id'];
            $user->name = $result['name'];
            $user->email = $result['email'];
            $user->password = $result['password'];
            return $user;
        }

        return null;
    }

    public static function getUserById(int $id): ?User
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM users WHERE id = :id";
        $params = [':id' => $id];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData !== false) {
                $user = new User();
                $user->id = $userData['id'];
                $user->setName($userData['name']);
                $user->setEmail($userData['email']);
                $user->setPassword($userData['password']);
                return $user;
            }
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }

        return null;
    }

    public static function logout(): void
    {
        session_start();

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
