<?php
use app\models\Usuario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Listado de Usuarios';
$this->params['breadcrumbs'][] = $this->title;

// Obtener usuario actual y sus permisos
$user = Yii::$app->user->identity;
$puedeCrear = $user && $user->puede('crear');
$puedeEditar = $user && $user->puede('editar');
$puedeEliminar = $user && $user->puede('eliminar');
?>
<div class="usuario-index">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><?= Html::encode($this->title) ?></h3>
            <div class="float-right">
                <?php if ($puedeCrear): ?>
                    <?= Html::a('<i class="fas fa-plus"></i> Nuevo Usuario', ['create'], ['class' => 'btn btn-light btn-sm']) ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped table-hover'],
                'options' => ['class' => 'table-responsive'],
                'columns' => [
                    [
                        'attribute' => 'username',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a(Html::encode($model->username), ['view', 'id' => $model->id], 
                                ['class' => 'text-primary font-weight-bold']);
                        }
                    ],
                    'nombre',
                    'email:email',
                    [
                        'attribute' => 'rol',
                        'value' => function($model) {
                            return $model->displayRol();
                        },
                        'contentOptions' => ['class' => 'text-center']
                    ],
                    [
                        'attribute' => 'activo',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->activo ? 
                                '<span class="badge bg-success">Activo</span>' : 
                                '<span class="badge bg-secondary">Inactivo</span>';
                        },
                        'contentOptions' => ['class' => 'text-center']
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{view}' . 
                                     ($puedeEditar ? ' {update}' : '') . 
                                     ($puedeEliminar ? ' {delete}' : ''),
                        'contentOptions' => ['style' => 'width: 120px; text-align: center;'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'title' => 'Ver detalles',
                                    'data-toggle' => 'tooltip'
                                ]);
                            },
                            'update' => function ($url, $model) use ($puedeEditar) {
                                if (!$puedeEditar) return '';
                                return Html::a('<i class="fas fa-edit"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-info',
                                    'title' => 'Editar',
                                    'data-toggle' => 'tooltip'
                                ]);
                            },
                            'delete' => function ($url, $model) use ($puedeEliminar) {
                                // No permitir que el usuario se elimine a sí mismo
                                if (!$puedeEliminar || $model->id == Yii::$app->user->id) return '';
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'title' => 'Eliminar',
                                    'data-toggle' => 'tooltip',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de eliminar este usuario?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, \app\models\User $model, $key, $index, $column) {
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