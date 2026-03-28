<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\forms\backend\Translator\TranslatorForm $translatorForm
 */

$this->title = 'Создать переводчика';
$this->params['breadcrumbs'][] = ['label' => 'Переводчики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="translator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'translatorForm' => $translatorForm,
    ]) ?>

</div>
