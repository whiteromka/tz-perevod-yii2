<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Translator $model
 */

$this->title = $model->name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Переводчики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="translator-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'last_name',
            'email:email',
            'price',
            [
                'attribute' => 'status',
                'value' => $model->getRuStatus(),
            ],
            [
                'attribute' => 'works_mode',
                'value' => $model->getRuWorksMode(),
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
