<?php

namespace common\repositories;

use common\models\User;
use yii\db\Exception;

/**
 * Repository для работы с пользователями
 */
class UserRepository
{
    /**
     * Проверка существования пользователя по username или email
     *
     * @param string $username
     * @param string $email
     * @return bool
     */
    public function existsByUsernameOrEmail(string $username, string $email): bool
    {
        return User::find()
            ->where(['or', ['username' => $username], ['email' => $email]])
            ->exists();
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
    public function create(string $username, string $email, string $password): User
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;

        if (!$user->save()) {
            throw new Exception('Ошибка при сохранении пользователя: ' . implode(', ', $user->getFirstErrors()));
        }

        return $user;
    }
}
