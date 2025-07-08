<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AvanceAlumno $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="AvanceAlumno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alumno_id')->textInput() ?>

    <?= $form->field($model, 'requisito_id')->textInput() ?>

    <?= $form->field($model, 'completado')->textInput() ?>

    <?= $form->field($model, 'fecha_completado')->textInput() ?>

    <?= $form->field($model, 'evidencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comentarios')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'validado_por')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
