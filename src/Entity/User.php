<?php
declare(strict_types=1);

namespace App\Entity;

class User
{
    private ?int $id;
    private string $email;
    private string $firstName;
    private string $lastName;
    private string $password;
    private int $role;

    public function __construct(
        ?int $id,
        string $email,
        string $firstName,
        string $lastName,
        string $password,
        int $role,
    )
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->role = $role;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
