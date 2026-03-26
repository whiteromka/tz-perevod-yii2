<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Translator $model
 */

$this->title = 'Создать переводчика';
$this->params['breadcrumbs'][] = ['label' => 'Переводчики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin();
?>

<div class="translator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
    ]) ?>

</div>

<?php ActiveForm::end(); ?>
