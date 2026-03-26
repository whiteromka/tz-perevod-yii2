<?php

namespace common\services;

use common\models\Translator;
use common\models\TranslatorSearch;
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
            'messge' => $message,
            'items' => $items,
            'total' => $total
        ];
    }

    /**
     * Получить список переводчиков с фильтрами и пагинацией
     *
     * @param array $params
     * @return array
     */
    public function getList(array $params): array
    {
        $searchModel = new TranslatorSearch();
        $dataProvider = $searchModel->search($params);

        return [
            'items' => $dataProvider->getModels(),
            'pagination' => [
                'total' => $dataProvider->getTotalCount(),
                'page' => $dataProvider->getPagination()->getPage() + 1,
                'per-page' => $dataProvider->getPagination()->getPageSize(),
                'page-count' => $dataProvider->getPagination()->getPageCount(),
            ],
            'filters' => [
                'statusList' => Translator::getStatusList(),
                'worksModeList' => Translator::getWorksModeList(),
            ],
        ];
    }

    /**
     * Создать нового переводчика
     *
     * @param array $data
     * @return Translator
     * @throws \yii\db\Exception
     */
    public function create(array $data): Translator
    {
        $translator = new Translator();
        $translator->setAttributes($data);
        
        if (!$translator->save()) {
            throw new \yii\web\UnprocessableEntityHttpException('Ошибка при создании переводчика');
        }
        
        return $translator;
    }

    /**
     * Обновить данные переводчика
     *
     * @param int $id
     * @param array $data
     * @return Translator
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function update(int $id, array $data): Translator
    {
        $translator = $this->getById($id);
        $translator->setAttributes($data);
        
        if (!$translator->save()) {
            throw new \yii\web\UnprocessableEntityHttpException('Ошибка при обновлении переводчика');
        }
        
        return $translator;
    }

    /**
     * Удалить переводчика
     *
     * @param int $id
     * @return bool
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function delete(int $id): bool
    {
        $translator = $this->getById($id);
        return $translator->delete();
    }

    /**
     * Получить поисковую модель с данными
     *
     * @param array $params
     * @return array
     */
    public function getSearchModel(array $params): array
    {
        $searchModel = new TranslatorSearch();
        $dataProvider = $searchModel->search($params);

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }
}
