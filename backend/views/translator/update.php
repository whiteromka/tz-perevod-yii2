<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\forms\backend\Translator\TranslatorForm $translatorForm
 */

$this->title = 'Изменить переводчика: ' . $translatorForm->name . ' ' . $translatorForm->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Переводчики', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $translatorForm->name, 'url' => ['view', 'id' => Yii::$app->request->get('id')]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<div class="translator-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'translatorForm' => $translatorForm,
    ]) ?>

</div>
