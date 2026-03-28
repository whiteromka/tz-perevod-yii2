<?php

namespace api\controllers;

use common\models\Enums\TranslatorStatus;
use common\models\Enums\TranslatorWorksMode;
use common\search\TranslatorSearch;
use common\services\TranslatorService;
use yii\filters\Cors;
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
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 3600,
            ],
        ];
        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
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
                'statusList' => TranslatorStatus::labels(),
                'worksModeList' => TranslatorWorksMode::labels(),
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
