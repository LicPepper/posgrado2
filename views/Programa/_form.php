<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Programa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="programa-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'nivel')->dropDownList(
                        $model::optsNivel(), 
                        ['prompt' => 'Seleccione un nivel']
                    ) ?>
                </div>
            </div>

            <?= $form->field($model, 'descripcion')->textarea(['rows' => 4]) ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-save"></i> ' . Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
                <?= Html::a('<i class="fas fa-times"></i> ' . Yii::t('app', 'Cancelar'), ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>