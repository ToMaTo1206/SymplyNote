<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class User
{
    private int $id;

    private string $firstName;

    private string $lastName;

    private string $email;

    private string $login;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
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
SELECT id, firstName, lastName,login, phone
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

}