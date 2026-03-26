<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Translator $model
 */

$this->title = 'Изменить переводчика: ' . $model->name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Переводчики', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';

$form = ActiveForm::begin();
?>

<div class="translator-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
    ]) ?>

</div>

<?php ActiveForm::end(); ?>
