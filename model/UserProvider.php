<?php

include_once "exceptions/UserExistsException.php";

class UserProvider
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * @throws UserExistsException
     */
    public function registerUser(User $user, string $plainPassword): bool
    {

        $isExistedStatement = $this->pdo->prepare('SELECT id FROM users WHERE username = ?');

        $isExistedStatement->execute([$user->getUsername()]);

        if ($isExistedStatement->fetch()) {
            throw new UserExistsException("Такой пользователь существует");
        }

        $statement = $this->pdo->prepare(
            'INSERT INTO users (name, username, password) VALUES (:name, :username, :password)'
        );

        $statement->execute([
            'name' => $user->getName(),
            'username' => $user->getUsername(),
            'password' => md5($plainPassword)
        ]);


        return $this->pdo->lastInsertId();
    }


// Метод получения пользователя. Если данные не совпали, вернет null
    public function getByUsernameAndPassword(string $username, string $password): ?User
    {
        $statement = $this->pdo->prepare(
            'SELECT id, name, username FROM users WHERE username = :username AND password = :password LIMIT 1'
        );
        $statement->execute([
            'username' => $username,
            'password' => md5($password)
        ]);
        return $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class)[0] ?: null;

        // fetch может вернуть false, а мы поддерживаем только null и User
    }

}