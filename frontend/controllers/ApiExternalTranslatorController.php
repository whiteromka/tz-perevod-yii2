<?php

namespace frontend\controllers;

use common\services\TranslatorService;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

/**
 * REST API контроллер для работы с переводчиками (внешний API)
 */
class ApiExternalTranslatorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // CORS заголовки для внешнего API
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
        Yii::$app->response->headers->add('Access-Control-Allow-Methods', 'GET, OPTIONS');
        Yii::$app->response->headers->add('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    /**
     * Получить список всех активных переводчиков
     * GET api/external/translator/active
     *
     * @return array
     */
    public function actionActive(): array
    {
        return Yii::$container->get(TranslatorService::class)->getAllActive();
    }

    /**
     * Получить переводчика по ID
     * GET /api/external/translator/id/1
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
     * GET /api/external/translator/email/test@example.com
     *
     * @param string $email
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionByEmail(string $email): array
    {
        return Yii::$container->get(TranslatorService::class)->getByEmail($email)->toArray();
    }
}
