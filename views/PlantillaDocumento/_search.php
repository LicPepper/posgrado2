<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PlantillaDocumentoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="PlantillaDocumento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'programa_id') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'contenido') ?>

    <?php // echo $form->field($model, 'campos_dinamicos') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
