<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Контроллер для отображения страницы переводчиков
 */
class TranslatorController extends Controller
{
    /**
     * Страница списка переводчиков с Vue.js
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
