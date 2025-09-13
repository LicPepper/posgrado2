<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Programa;

/** @var yii\web\View $this */
/** @var app\models\ProgramaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="programa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline'
        ],
    ]); ?>

    <div class="row align-items-end">
        <div class="col-md-3">
            <?= $form->field($model, 'id')->textInput(['placeholder' => 'ID']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'nombre')->textInput(['placeholder' => 'Nombre']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'nivel')->dropDownList(
                Programa::optsNivel(), 
                ['prompt' => 'Todos los niveles']
            ) ?>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-search"></i> ' . Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fas fa-redo"></i> ' . Yii::t('app', 'Limpiar'), ['index'], ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>