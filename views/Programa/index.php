<?php

use app\models\Programa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProgramaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Listado de Programas';
$this->params['breadcrumbs'][] = $this->title;

// Obtener usuario actual y sus permisos
$user = Yii::$app->user->identity;
$puedeCrear = $user && $user->puede('crear');
$puedeEditar = $user && $user->puede('editar');
$puedeEliminar = $user && $user->puede('eliminar');

?>
<div class="programa-index">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><?= Html::encode($this->title) ?></h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-plus"></i> Nuevo Programa', ['create'], ['class' => 'btn btn-light btn-sm']) ?>
            </div>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-hover'],
                'options' => ['class' => 'table-responsive'],
                'columns' => [
                    [
                        'attribute' => 'nombre',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a(Html::encode($model->nombre), ['view', 'id' => $model->id], 
                                ['class' => 'text-primary font-weight-bold']);
                        }
                    ],
                    [
                        'attribute' => 'nivel',
                        'value' => function($model) {
                            return $model->displayNivel();
                        },
                        'filter' => Programa::optsNivel(),
                        'contentOptions' => ['class' => 'text-center']
                    ],
                    [
                        'attribute' => 'descripcion',
                        'value' => function($model) {
                            return $model->descripcion ? substr($model->descripcion, 0, 50) . '...' : '<span class="text-muted">N/A</span>';
                        },
                        'format' => 'raw'
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{view} {update} {delete}',
                        'contentOptions' => ['style' => 'width: 120px; text-align: center;'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'title' => 'Ver detalles',
                                    'data-toggle' => 'tooltip'
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-edit"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-info',
                                    'title' => 'Editar',
                                    'data-toggle' => 'tooltip'
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'title' => 'Eliminar',
                                    'data-toggle' => 'tooltip',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de eliminar este programa?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, Programa $model, $key, $index, $column) {
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