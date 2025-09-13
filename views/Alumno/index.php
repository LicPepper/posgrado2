<?php

use app\models\Alumno;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\AlumnoSearch $searchModel */

$this->title = 'Listado de Alumnos';
$this->params['breadcrumbs'][] = $this->title;

// Obtener usuario actual y sus permisos
$user = Yii::$app->user->identity;
$puedeCrear = $user && $user->puede('crear');
$puedeEditar = $user && $user->puede('editar');
$puedeEliminar = $user && $user->puede('eliminar');

?>
<div class="alumno-index">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><?= Html::encode($this->title) ?></h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-plus"></i> Nuevo Alumno', ['create'], ['class' => 'btn btn-light btn-sm']) ?>
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
                        'attribute' => 'matricula',
                        'label' => 'Matrícula',
                        'contentOptions' => ['class' => 'text-center font-monospace'],
                        'headerOptions' => ['class' => 'text-center'],
                        'filter' => Html::input('text', 'AlumnoSearch[matricula]', $searchModel->matricula, [
                            'class' => 'form-control form-control-sm',
                            'placeholder' => 'Buscar matrícula'
                        ]),
                    ],
                     [
                        'attribute' => 'programa_id',
                        'label' => 'Programa',
                        'value' => function($model) {
                            return $model->programa->nombre ?? '<span class="text-muted">N/A</span>';
                        },
                        'format' => 'raw',
                        'filter' => Html::dropDownList(
                            'AlumnoSearch[programa_id]', 
                            $searchModel->programa_id, 
                            \yii\helpers\ArrayHelper::map(\app\models\Programa::find()->all(), 'id', 'nombre'),
                            [
                                'class' => 'form-control form-control-sm',
                                'prompt' => 'Todos los programas'
                            ]
                        ),
                    ],
                    [
                        'attribute' => 'nombre',
                        'label' => 'Nombre',
                        'value' => function($model) {
                            return Html::a(Html::encode($model->nombre), ['view', 'id' => $model->id], 
                                ['class' => 'text-primary font-weight-bold']);
                        },
                        'format' => 'raw',
                        'filter' => Html::input('text', 'AlumnoSearch[nombre]', $searchModel->nombre, [
                            'class' => 'form-control form-control-sm',
                            'placeholder' => 'Buscar nombre'
                        ]),
                    ],
                    [
                        'attribute' => 'apellido_paterno',
                        'label' => 'Apellido Paterno',
                        'filter' => Html::input('text', 'AlumnoSearch[apellido_paterno]', $searchModel->apellido_paterno, [
                            'class' => 'form-control form-control-sm',
                            'placeholder' => 'Buscar ap. paterno'
                        ]),
                    ],
                    [
                        'attribute' => 'apellido_materno',
                        'label' => 'Apellido Materno',
                        'filter' => Html::input('text', 'AlumnoSearch[apellido_materno]', $searchModel->apellido_materno, [
                            'class' => 'form-control form-control-sm',
                            'placeholder' => 'Buscar ap. materno'
                        ]),
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
                        'urlCreator' => function ($action, Alumno $model, $key, $index, $column) {
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