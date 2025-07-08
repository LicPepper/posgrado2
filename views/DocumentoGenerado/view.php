<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\DocumentoGenerado $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Documento Generados'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="DocumentoGenerado-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'alumno_id',
            'value' => $model->alumno->nombreCompleto ?? 'N/A'
        ],
        [
            'attribute' => 'plantilla_id',
            'value' => $model->plantilla->nombre ?? 'N/A'
        ],
        [
            'attribute' => 'ruta_archivo',
            'format' => 'raw',
            'value' => Html::a(basename($model->ruta_archivo), ['download', 'id' => $model->id])
        ],
        'fecha_generacion:datetime',
        [
            'attribute' => 'estado',
            'value' => $model->displayEstado()
        ],
    ],
]) ?>

</div>
