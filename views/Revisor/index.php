<?php

use app\models\Revisor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RevisorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Listado de Revisores';
$this->params['breadcrumbs'][] = $this->title;

// Obtener usuario actual y sus permisos
$user = Yii::$app->user->identity;
$puedeCrear = $user && $user->puede('crear');
$puedeEditar = $user && $user->puede('editar');
$puedeEliminar = $user && $user->puede('eliminar');

?>
<div class="revisor-index">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><?= Html::encode($this->title) ?></h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-plus"></i> Nuevo Revisor', ['create'], ['class' => 'btn btn-light btn-sm']) ?>
            </div>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel, // Modelo de búsqueda para filtrado
                'tableOptions' => ['class' => 'table table-striped table-hover'],
                'options' => ['class' => 'table-responsive'],
                'columns' => [
                    [
                        'attribute' => 'nombre',
                        'value' => function($model) {
                            return Html::encode($model->nombre);
                        },
                        'filterInputOptions' => [
                            'class' => 'form-control form-control-sm',
                            'placeholder' => 'Buscar nombre'
                        ]
                    ],
                    [
                        'attribute' => 'cargo',
                        'value' => function($model) {
                            return Html::encode($model->cargo);
                        },
                        'filterInputOptions' => [
                            'class' => 'form-control form-control-sm',
                            'placeholder' => 'Buscar cargo'
                        ]
                    ],
                    [
                        'attribute' => 'activo',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->activo ? 
                                '<span class="badge bg-success">Activo</span>' : 
                                '<span class="badge bg-secondary">Inactivo</span>';
                        },
                        'contentOptions' => ['class' => 'text-center'],
                        'filter' => [
                            1 => 'Activo',
                            0 => 'Inactivo'
                        ],
                        'filterInputOptions' => [
                            'class' => 'form-control form-control-sm',
                            'prompt' => 'Todos'
                        ]
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{view}',
                        'contentOptions' => ['style' => 'width: 70px; text-align: center;'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'title' => 'Ver detalles',
                                    'data-toggle' => 'tooltip'
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, Revisor $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
                'pager' => [
                    'options' => ['class' => 'pagination justify-content-center mt-3'],
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'linkOptions' => ['class' => 'page-link'],
                    'disabledListItemSubTagOptions' => ['class' => 'page-link']
                ],
            ]); ?>
        </div>
        <div class="card-footer text-muted">
            <div class="row">
                <div class="col-md-6">
                    Mostrando <?= $dataProvider->getCount() ?> de <?= $dataProvider->getTotalCount() ?> registros
                </div>
                <div class="col-md-6 text-right">
                    <?= date('d/m/Y H:i') ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
// Registrar JavaScript para tooltips
$this->registerJs("
    $(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();
    });
");
?>