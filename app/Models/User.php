<?php
namespace App\Models;

class User
{
	protected int $id;
	protected string $username;
	protected string $email;
	protected string $title;


    // GET METHODS
	public function getId()
	{
		return $this->id;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getEmail()
	{
		return $this->email;
	}


    // SET METHODS
    public function setUsername(string $username)
	{
		$this->username = $username;
	}

	public function setEmail(string $email)
	{
		$this->email = $email;
	}
    public function create(array $data)
	{

	}

	public function update(int $id, array $data)
	{

	}

	public function delete(int $id)
	{

	}
}
