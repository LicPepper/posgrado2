<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Requisito $model */

$this->title = 'Actualizar Requisito: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Requisitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';

$tiposDocumentos = app\models\Requisito::getTiposDocumentos();
$programas = yii\helpers\ArrayHelper::map(app\models\Programa::find()->all(), 'id', 'nombre');
?>
<div class="requisito-update">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><?= Html::encode($this->title) ?></h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-arrow-left"></i> Volver', ['index'], ['class' => 'btn btn-light btn-sm']) ?>
            </div>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'tiposDocumentos' => $tiposDocumentos,
                'programas' => $programas
            ]) ?>
        </div>
    </div>

</div>