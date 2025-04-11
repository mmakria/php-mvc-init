<?php

namespace App\Models;

class User extends Model
{
    public function __construct(
        protected ?int       $id = null,
        protected ?string    $firstName = null,
        protected ?string    $lastName = null,
        protected ?string    $password = null,
        protected ?string    $email = null,
        protected ?\DateTime $createdAt = null,
        protected ?array     $roles = null,
    )
    {
        $this->table = "users";
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getRoles(): ?array
    {
        $this->roles[] = "ROLE_USER";
        return array_unique($this->roles);
    }

    public function setRoles(null|array|string $roles): self
    {
        if (is_string($roles)) {
            $this->roles = json_decode($roles ?? '[]');
        } else {
            $this->roles = $roles;
        }
        return $this;
    }

}