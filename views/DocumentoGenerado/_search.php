<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DocumentoGeneradoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="DocumentoGenerado-search mb-4">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'row g-3'
        ],
    ]); ?>

     <div class="col-md-4">
        <?= $form->field($model, 'alumno_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(
                \app\models\Alumno::find()->all(),
                'id',
                'nombreCompleto'
            ),
            ['prompt' => 'Todos los alumnos']
        ) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'plantilla_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(
                \app\models\PlantillaDocumento::find()->all(),
                'id',
                'nombre'
            ),
            ['prompt' => 'Todos los tipos']
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'estado')->dropDownList([
            'Generado' => 'Generado',
            'Validado' => 'Validado',
            'Rechazado' => 'Rechazado'
        ], ['prompt' => 'Todos']) ?>
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <div class="form-group">
            <?= Html::submitButton('<i class="fas fa-search"></i> Buscar', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
