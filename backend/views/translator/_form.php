<?php

use common\models\Enums\TranslatorStatus;
use common\models\Enums\TranslatorWorksMode;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\forms\backend\Translator\TranslatorForm $translatorForm
 * @var ActiveForm $form
 */
?>

<div class="translator-form">

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'needs-validation']]); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($translatorForm, 'name', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-control'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($translatorForm, 'last_name', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-control'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($translatorForm, 'email', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-control', 'type' => 'email'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($translatorForm, 'price', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-control', 'type' => 'number', 'min' => 0],
                    ])->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($translatorForm, 'status', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-select'],
                    ])->dropDownList(
                        TranslatorStatus::labels(),
                        ['prompt' => 'Выберите статус']
                    ) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($translatorForm, 'works_mode', [
                        'options' => ['class' => 'form-group mb-3'],
                        'inputOptions' => ['class' => 'form-select'],
                    ])->dropDownList(
                        TranslatorWorksMode::labels(),
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
