<?php

namespace backend\controllers;

use common\forms\backend\Translator\TranslatorForm;
use common\models\Translator;
use common\search\TranslatorSearch;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Контроллер для управления переводчиками
 */
class TranslatorController extends Controller
{
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
        $searchModel = new TranslatorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание нового переводчика
     */
    public function actionCreate()
    {
        $translatorForm = new TranslatorForm();
        if ($translatorForm->load(Yii::$app->request->post()) && $translatorForm->validate()) {
            $translator = new Translator();
            $translator->setAttributes($translatorForm->attributesToArray());
            if ($translator->save()) {
                return $this->redirect(['view', 'id' => $translator->id]);
            }

            Yii::$app->session->setFlash('error', 'Ошибка при создании переводчика');
        }

        return $this->render('create', [
            'translatorForm' => $translatorForm,
        ]);
    }

    /**
     * Редактирование переводчика
     *
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $translator = $this->findModel($id);
        $translatorForm = new TranslatorForm();
        $translatorForm->setAttributes($translator->getAttributes());

        if ($translatorForm->load(Yii::$app->request->post()) && $translatorForm->validate()) {
            $translator->setAttributes($translatorForm->attributesToArray());
            if ($translator->save()) {
                return $this->redirect(['view', 'id' => $translator->id]);
            }

            Yii::$app->session->setFlash('error', 'Ошибка при обновлении переводчика');
        }

        return $this->render('update', [
            'translatorForm' => $translatorForm,
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
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Найти модель по ID
     *
     * @param int $id
     * @return Translator
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Translator
    {
        $model = Translator::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException("Переводчик с ID {$id} не найден");
        }
        return $model;
    }
}
