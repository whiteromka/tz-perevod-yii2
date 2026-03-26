<?php

use common\models\Translator;
use common\models\TranslatorSearch;
use yii\bootstrap5\LinkPager;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var TranslatorSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Переводчики';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="translator-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать переводчика', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => ['class' => LinkPager::class,],
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'last_name',
            'email:email',
            'price',
            [
                'attribute' => 'status',
                'filter' => Translator::getStatusList(),
                'value' => function (Translator $model) {
                    return $model->getRuStatus();
                },
            ],
            [
                'attribute' => 'works_mode',
                'filter' => Translator::getWorksModeList(),
                'value' => function (Translator $model) {
                    return $model->getRuWorksMode();
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>
