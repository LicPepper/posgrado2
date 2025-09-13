<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Crear Nuevo Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="usuario-create">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-list"></i> Volver', ['index'], ['class' => 'btn btn-light btn-sm']) ?>
            </div>
        </div>
        <div class="card-body">
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
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'activo')->checkbox([
                        'label' => 'Usuario activo',
                        'checked' => true
                    ]) ?>
                </div>
            </div>

            <div class="form-group mt-4">
                <?= Html::submitButton('<i class="fas fa-save"></i> Crear Usuario', ['class' => 'btn btn-success']) ?>
                <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>