<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\DocumentoGenerado $model */

$this->title = 'Documento: ' . ($model->plantilla->nombre ?? 'N/A');
$this->params['breadcrumbs'][] = ['label' => 'Documentos Generados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="documento-generado-view">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="card-title">
                <i class="fas fa-file-pdf"></i> <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <div class="card-body">
            
            <!-- Información del documento -->
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                   
                    [
                        'attribute' => 'plantilla_id',
                        'value' => $model->plantilla->nombre ?? 'N/A'
                    ],
                    [
                        'attribute' => 'ruta_archivo',
                        'format' => 'raw',
                        'value' => Html::a(basename($model->ruta_archivo), ['download', 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-primary'])
                    ],
                    'fecha_generacion:datetime',
                    [
                        'attribute' => 'estado',
                        'format' => 'raw',
                        'value' => $model->getEstadoLabel()
                    ],
                    'version',
                ],
            ]) ?>

            <!-- Visualizador del PDF -->
            <div class="mt-4">
                <h4><i class="fas fa-eye"></i> Vista previa del documento</h4>
                <div class="embed-responsive embed-responsive-16by9" style="height: 600px;">
                    <iframe class="embed-responsive-item" 
                            src="<?= Yii::$app->urlManager->createUrl(['documento-generado/stream', 'id' => $model->id]) ?>" 
                            frameborder="0" 
                            style="width: 100%; height: 100%;">
                    </iframe>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="mt-4">
                <?= Html::a(
                    '<i class="fas fa-download"></i> Descargar PDF', 
                    ['download', 'id' => $model->id], 
                    ['class' => 'btn btn-success btn-lg']
                ) ?>
                <?= Html::a(
                    '<i class="fas fa-history"></i> Ver historial del alumno', 
                    ['ver-historia', 'alumno_id' => $model->alumno_id], 
                    ['class' => 'btn btn-info btn-lg']
                ) ?>
                <?= Html::a(
                    '<i class="fas fa-arrow-left"></i> Volver al listado', 
                    ['index'], 
                    ['class' => 'btn btn-secondary']
                ) ?>
            </div>

        </div>
    </div>

</div>