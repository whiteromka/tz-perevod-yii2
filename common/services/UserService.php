<?php

namespace common\services;

use common\models\User;
use common\repositories\UserRepository;
use Exception;

/**
 * Сервис для работы с пользователями
 */
class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Создание нового пользователя
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @return User
     * @throws Exception
     */
    public function createUser(string $username, string $email, string $password): User
    {
        $isUserExists = $this->userRepository->existsByUsernameOrEmail($username, $email);
        if ($isUserExists) {
            throw new Exception('Пользователь с таким email или username уже существует');
        }
        return $this->userRepository->create($username, $email, $password);
    }
}
