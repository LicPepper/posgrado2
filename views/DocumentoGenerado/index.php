<?php

use app\models\DocumentoGenerado;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\DocumentoGeneradoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Historial de Documentos Generados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="DocumentoGenerado-index">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="card-title">
                <i class="fas fa-file-alt"></i> <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'alumno_id',
                            'value' => function($model) {
                                return $model->alumno->nombreCompleto ?? 'N/A';
                            },
                            'filter' => \yii\helpers\ArrayHelper::map(
                                \app\models\Alumno::find()->all(),
                                'id',
                                'nombreCompleto'
                            )
                        ],
                        [
                            'attribute' => 'plantilla_id',
                            'value' => function($model) {
                                return $model->plantilla->nombre ?? 'N/A';
                            },
                            'filter' => \yii\helpers\ArrayHelper::map(
                                \app\models\PlantillaDocumento::find()->all(),
                                'id',
                                'nombre'
                            )
                        ],
                        'fecha_generacion:datetime',
                        [
                            'attribute' => 'estado',
                            'value' => function($model) {
                                return $model->displayEstado();
                            },
                            'filter' => [
                                'Generado' => 'Generado',
                                'Validado' => 'Validado', 
                                'Rechazado' => 'Rechazado'
                            ]
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{view} {download}',
                            'buttons' => [
                                'download' => function ($url, $model) {
                                    return Html::a(
                                        '<i class="fas fa-download"></i>',
                                        ['download', 'id' => $model->id],
                                        ['class' => 'btn btn-sm btn-success', 'title' => 'Descargar']
                                    );
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>