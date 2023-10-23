<?php

namespace App\Models;

use AllowDynamicProperties;
use App\Exceptions\NotFoundObjectException;
use App\Helpers\DatabaseHelper;
use DateTime;

#[AllowDynamicProperties]
class User
{
    protected int $id;

    protected string $name;

    protected string $email;

    protected string $password;

    protected ?string $created_at = null;

    protected ?string $updated_at = null;

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

    public function setCreatedAt(string $createdAt): self
    {
        $this->created_at = $createdAt;
        return $this;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updated_at = $updatedAt;
        return $this;
    }

    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * @throws NotFoundObjectException
     */
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
        $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $params = [
            ':id' => $this->id,
            ':name' => $this->name,
            ':email' => $this->email
        ];

        DatabaseHelper::executeQuery($sql, $params);
    }

    public function create(): void
    {
        $sql = "INSERT INTO users (name, email, password, created_at, updated_at) 
                VALUES (:name, :email, :password, NOW(), NOW())";
        $params = [
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => $this->password
        ];

        DatabaseHelper::executeQuery($sql, $params);

        $this->id = Database::getInstance()->getConnection()->lastInsertId();
    }

    public static function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $params = [':email' => $email];

        $result = DatabaseHelper::executeFetchObject($sql, $params, 'App\Models\User');

        return $result ?? null;
    }

    public static function getUserById(int $id): ?User
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $params = [':id' => $id];

        $result = DatabaseHelper::executeFetchObject($sql, $params, null);

        if ($result) {
            $user = new User();
            $user->id = $result->id;
            $user->name = $result->name;
            $user->email = $result->email;
            $user->password = $result->password;
            return $user;
        } else {
           return null;
        }
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
