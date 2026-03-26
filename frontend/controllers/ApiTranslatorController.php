<?php

namespace frontend\controllers;

use common\models\Translator;
use common\models\TranslatorSearch;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

/**
 * REST API контроллер для работы с переводчиками
 */
class ApiTranslatorController extends Controller
{
    /**
     * Получить список переводчиков с фильтрами и пагинацией
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
}
