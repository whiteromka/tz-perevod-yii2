<?php

namespace common\services;

use common\models\Translator;
use common\repositories\TranslatorRepository;
use yii\web\NotFoundHttpException;

/**
 * Сервис для работы с переводчиками
 */
class TranslatorService
{
    /** @var TranslatorRepository */
    private TranslatorRepository $repository;

    /**
     * @param TranslatorRepository $repository
     */
    public function __construct(TranslatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получить переводчика по ID
     *
     * @param int $id
     * @return Translator
     * @throws NotFoundHttpException
     */
    public function getById(int $id): Translator
    {
        $translator = $this->repository->getById($id);

        if ($translator === null) {
            throw new NotFoundHttpException("Переводчик с ID {$id} не найден");
        }

        return $translator;
    }

    /**
     * Получить переводчика по email
     *
     * @param string $email
     * @return Translator
     * @throws NotFoundHttpException
     */
    public function getByEmail(string $email): Translator
    {
        $translator = $this->repository->getByEmail($email);

        if ($translator === null) {
            throw new NotFoundHttpException("Переводчик с email '{$email}' не найден");
        }

        return $translator;
    }

    /**
     * Получить всех активных переводчиков
     *
     * @return array
     */
    public function getAllActive(): array
    {
        $items = $this->repository->getAllActive();
        $total = count($items);
        $message = $total > 0 ? 'Список переводчиков готов' : 'Нет свободных переводчиков';
        return [
            'message' => $message,
            'items' => $items,
            'total' => $total
        ];
    }
}
