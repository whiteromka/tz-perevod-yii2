<?php

use common\models\Translator;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Translator $model
 * @var ActiveForm $form
 */
?>

<div class="translator-form">

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'needs-validation']]); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-control'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'last_name', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-control'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'email', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-control', 'type' => 'email'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'price', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-control', 'type' => 'number', 'min' => 0],
                    ])->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'status', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-select'],
                    ])->dropDownList(
                        Translator::getStatusList(),
                        ['prompt' => 'Выберите статус']
                    ) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'works_mode', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-select'],
                    ])->dropDownList(
                        Translator::getWorksModeList(),
                        ['prompt' => 'Выберите режим работы']
                    ) ?>
                </div>
            </div>

            <div class="form-group mt-4">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-lg']) ?>
                <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary btn-lg']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
