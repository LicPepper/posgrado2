<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Crear Revisor';
$this->params['breadcrumbs'][] = ['label' => 'Revisores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="revisor-create">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'cargo')->textInput([
                'maxlength' => true,
                'value' => 'CATEDRÁTICO DEL INSTITUTO TECNOLÓGICO DE VILLAHERMOSA'
            ]) ?>

             <?= $form->field($model, 'activo')->dropDownList(
                        [1 => 'Sí', 0 => 'No'],
                        ['prompt' => 'Seleccione una opción...', 'class' => 'form-control', 'required' => true]
                    )->label('Activo') ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-success']) ?>
                <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['index'], ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
