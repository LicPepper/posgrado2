<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DocumentoGenerado $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="DocumentoGenerado-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alumno_id')->textInput() ?>

    <?= $form->field($model, 'plantilla_id')->textInput() ?>

    <?= $form->field($model, 'ruta_archivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hash_verificacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_generacion')->textInput() ?>

    <?= $form->field($model, 'generado_por')->textInput() ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'estado')->dropDownList([ 'Generado' => 'Generado', 'Validado' => 'Validado', 'Rechazado' => 'Rechazado', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'comentarios')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
