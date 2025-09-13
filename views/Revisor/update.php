<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Actualizar Revisor: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Revisores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>

<div class="revisor-update">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'activo')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-success']) ?>
                <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
