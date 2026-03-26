<?php

namespace backend\controllers;

use common\models\Translator;
use common\services\TranslatorService;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Контроллер для управления переводчиками
 */
class TranslatorController extends Controller
{
    /** @var TranslatorService */
    private TranslatorService $translatorService;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->translatorService = Yii::$container->get(TranslatorService::class);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Список переводчиков
     *
     * @return string
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $result = $this->translatorService->getSearchModel($params);

        return $this->render('index', [
            'searchModel' => $result['searchModel'],
            'dataProvider' => $result['dataProvider'],
        ]);
    }

    /**
     * Просмотр одного переводчика
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->translatorService->getById($id),
        ]);
    }

    /**
     * Создание нового переводчика
     */
    public function actionCreate()
    {
        $model = new Translator();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Редактирование переводчика
     *
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Удаление переводчика
     *
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionDelete($id)
    {
        $this->translatorService->delete($id);
        return $this->redirect(['index']);
    }
}
