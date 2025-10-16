<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class User
{
    private int $id;

    private string $firstName;

    private string $lastName;

    private string $email = "Pas d'email renseignée";

    private string $login;

    private string $phone;

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @throws EntityNotFoundException
     */
    public static function findByCredentials(string $login, string $password): User
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
SELECT id, firstName, lastName,email,login, phone
FROM user
WHERE login = :login AND sha512pass = SHA2(:password,512)
SQL
        );
        $stmt->execute(['login' => $login, 'password' => $password]);
        $user = $stmt->fetchObject(User::class);

        if (!$user) {
            throw new EntityNotFoundException("Pas d'utilisateur trouvé");
        }

        return $user;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }


}
