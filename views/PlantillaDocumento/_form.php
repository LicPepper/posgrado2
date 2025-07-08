<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PlantillaDocumento $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="PlantillaDocumento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'programa_id')->textInput() ?>

    <?= $form->field($model, 'tipo')->dropDownList([ 'Constancia' => 'Constancia', 'Carta Liberación' => 'Carta Liberación', 'Kardex' => 'Kardex', 'Otro' => 'Otro', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'contenido')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'campos_dinamicos')->textInput() ?>

    <?= $form->field($model, 'activo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
