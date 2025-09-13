<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap5\Modal;
use app\models\Requisito;
use yii\helpers\ArrayHelper;

$this->title = 'Administración de Requisitos por Documento';
$this->params['breadcrumbs'][] = ['label' => 'Requisitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$tiposDocumentos = Requisito::getTiposDocumentos();
?>

<div class="requisito-admin">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">
                <i class="fas fa-cog"></i> <?= Html::encode($this->title) ?>
            </h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-list"></i> Ver Todos los Requisitos', 
                    ['index'], 
                    ['class' => 'btn btn-light btn-sm']) ?>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filtro por tipo de documento -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo-documento-filter">Filtrar por tipo de documento:</label>
                        <select id="tipo-documento-filter" class="form-control">
                            <option value="">Todos los documentos</option>
                            <?php foreach ($tiposDocumentos as $key => $value): ?>
                                <option value="<?= $key ?>" <?= ($tipo == $key) ? 'selected' : '' ?>>
                                    <?= $value ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 text-right" style="padding-top: 32px;">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearRequisitoModal">
                        <i class="fas fa-plus"></i> Nuevo Requisito
                    </button>
                </div>
            </div>

            <?php Pjax::begin(['id' => 'requisitos-pjax']); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-striped table-bordered'],
                'columns' => [
                    // SE ELIMINÓ: ['class' => 'yii\grid\SerialColumn'],
                    
                    // SE ELIMINÓ: la columna tipo_documento completa
                    /*[
                        'attribute' => 'tipo_documento',
                        'value' => function($model) use ($tiposDocumentos) {
                            return $tiposDocumentos[$model->tipo_documento] ?? $model->tipo_documento;
                        },
                        'filter' => $tiposDocumentos,
                    ],*/
                    
                    [
                        'attribute' => 'programa_id',
                        'value' => function($model) {
                            return $model->programa ? $model->programa->nombre : 'Todos los programas';
                        },
                        'filter' => ArrayHelper::map(\app\models\Programa::find()->all(), 'id', 'nombre'),
                    ],
                    
                    'nombre',
                    'descripcion',
                    
                    [
                        'attribute' => 'obligatorio',
                        'value' => function($model) {
                            return $model->obligatorio ? 
                                '<span class="badge bg-success">Sí</span>' : 
                                '<span class="badge bg-secondary">No</span>';
                        },
                        'format' => 'raw',
                        'filter' => [1 => 'Sí', 0 => 'No'],
                    ],
                    
                    [
                        'attribute' => 'orden',
                        'headerOptions' => ['style' => 'width:80px;'],
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-edit"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'title' => 'Editar'
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'title' => 'Eliminar',
                                    'data' => [
                                        'confirm' => '¿Está seguro de eliminar este requisito?',
                                        'method' => 'post',
                                    ],
                                ]);
                            }
                        ],
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>

<!-- Modal para crear requisito -->
<?php Modal::begin([
    'id' => 'crearRequisitoModal',
    'title' => '<h4 class="modal-title">Crear Nuevo Requisito</h4>',
    'size' => 'modal-lg'
]); ?>

<div class="modal-body">
    <?= $this->render('_form', [
        'model' => $newModel,
        'tiposDocumentos' => $tiposDocumentos,
        'programas' => $programas,
    ]) ?>
</div>

<?php Modal::end(); ?>

<?php
// JavaScript para el filtro
$js = <<<JS
// Filtro por tipo de documento
$('#tipo-documento-filter').change(function() {
    var tipo = $(this).val();
    if (tipo) {
        window.location.href = '/requisito/admin?tipo=' + tipo;
    } else {
        window.location.href = '/requisito/admin';
    }
});
JS;

$this->registerJs($js);
?>