<?php
namespace App\Models;

use App\Models\Database;
use DateTime;
use PDOException;

class User
{
	protected int $id;
	protected string $name;
	protected string $email;
	protected string $title;
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
    public function create(array $data)
	{

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

    public function save(): void
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

    public function read(int $id)
    {
        $this->name = 'Admin' ;
        $this->email = 'admin@gmail.com';

        return $this;
    }
}
