<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'rol')->dropDownList(
                \app\models\User::optsRol(),
                ['prompt' => 'Seleccionar rol']
            ) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true, 'required' => true]) ?>
            <small class="form-text text-muted">Dejar en blanco si no desea cambiar la contraseña</small>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'activo')->checkbox([
                'label' => 'Usuario activo',
                'checked' => $model->isNewRecord ? true : $model->activo
            ]) ?>
        </div>
    </div>

    <div class="form-group mt-4">
        <?= Html::submitButton('<i class="fas fa-save"></i> ' . Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>