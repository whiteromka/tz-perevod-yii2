<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;

/**
 * Команды:
 *      docker-compose exec backend php yii user-generate [<name> <email> <pass>]
 */
class UserGenerateController extends Controller
{
    /**
     * Создать пользователя
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @return int
     * @throws Exception
     */
    public function actionCreate($username = 'rom', $email = 'rom@rom.ru', $password = '123')
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;

        if ($user->save()) {
            $this->stdout("Пользователь успешно создан: '{$username}' '{$email}' '{$password}'\n");
            return ExitCode::OK;
        }

        $this->stderr("Ошибка: " . implode(', ', $user->getFirstErrors()) . "\n");
        return ExitCode::UNSPECIFIED_ERROR;
    }
}
