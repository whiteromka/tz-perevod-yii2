<?php

namespace console\controllers;

use common\services\UserService;
use Exception;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Команды:
 *      docker-compose exec backend php yii user/create [<name> <email> <pass>]
 */
class UserController extends Controller
{
    private UserService $userService;

    /**
     * {@inheritdoc}
     */
    public function __construct($id, $module, UserService $userService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
    }

    /**
     * Создать пользователя
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @return int
     */
    public function actionCreate($username = 'rom', $email = 'rom@rom.ru', $password = '123')
    {
        try {
            $user = $this->userService->createUser($username, $email, $password);
            if ($user) {
                $this->stdout("Пользователь успешно создан: '{$username}' '{$email}' '$password' \n");
                return ExitCode::OK;
            }
        } catch (Exception $e) {
            $this->stderr("Ошибка: {$e->getMessage()}\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
