<?php

namespace api\controllers;

use common\models\Translator;
use common\models\TranslatorSearch;
use common\services\TranslatorService;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * REST API контроллер для работы с переводчиками
 */
class TranslatorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
        // CORS заголовки для API
        Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
        Yii::$app->response->headers->add('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        Yii::$app->response->headers->add('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    /**
     * Получить список переводчиков с фильтрами и пагинацией
     * GET /v1/translators
     *
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionList(): array
    {
        $searchModel = new TranslatorSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

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
     * Получить список всех активных переводчиков
     * GET /v1/translators/active
     *
     * @return array
     */
    public function actionActive(): array
    {
        return Yii::$container->get(TranslatorService::class)->getAllActive();
    }

    /**
     * Получить переводчика по ID
     * GET /v1/translators/{id}
     *
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionById(int $id): array
    {
        return Yii::$container->get(TranslatorService::class)->getById($id)->toArray();
    }

    /**
     * Получить переводчика по email
     * GET /v1/translators/by-email?email=test@example.com
     *
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionByEmail(): array
    {
        $email = Yii::$app->request->get('email');
        if (!$email) {
            throw new NotFoundHttpException('Email не указан');
        }
        
        return Yii::$container->get(TranslatorService::class)->getByEmail($email)->toArray();
    }
}
