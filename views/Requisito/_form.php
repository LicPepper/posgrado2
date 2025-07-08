<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Requisito $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="requisito-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'programa_id')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'obligatorio')->textInput() ?>

    <?= $form->field($model, 'orden')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
