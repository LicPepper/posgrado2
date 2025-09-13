<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Alert;

/** @var app\models\Usuario $model */

$this->title = 'Editar Usuario: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>

<div class="usuario-update">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-list"></i> Volver', ['index'], ['class' => 'btn btn-light btn-sm']) ?>
            </div>
        </div>
        <div class="card-body">
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <?= Alert::widget([
                    'options' => ['class' => 'alert-success'],
                    'body' => Yii::$app->session->getFlash('success'),
                ]) ?>
            <?php endif; ?>

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
                    <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?>
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
                <?= Html::submitButton('<i class="fas fa-save"></i> Guardar Cambios', ['class' => 'btn btn-success']) ?>
                <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>