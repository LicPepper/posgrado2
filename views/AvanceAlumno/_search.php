<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AvanceAlumnoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="AvanceAlumno-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'alumno_id') ?>

    <?= $form->field($model, 'requisito_id') ?>

    <?= $form->field($model, 'completado') ?>

    <?= $form->field($model, 'fecha_completado') ?>

    <?php // echo $form->field($model, 'evidencia') ?>

    <?php // echo $form->field($model, 'comentarios') ?>

    <?php // echo $form->field($model, 'validado_por') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
