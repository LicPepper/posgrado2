<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Requisito;
use yii\helpers\ArrayHelper; 

$this->title = 'Gestión de Requisitos';
$this->params['breadcrumbs'][] = $this->title;

$tiposDocumentos = Requisito::getTiposDocumentos();
?>

<div class="requisito-index">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><?= Html::encode($this->title) ?></h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-plus"></i> Nuevo Requisito', ['create'], ['class' => 'btn btn-light btn-sm']) ?>
                <!-- ELIMINADO: Botón Administrar por Documento -->
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
                                <option value="<?= $key ?>" <?= (Yii::$app->request->get('tipo') == $key) ? 'selected' : '' ?>>
                                    <?= $value ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <?php Pjax::begin(['id' => 'requisitos-pjax']); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}\n{summary}",
                'tableOptions' => ['class' => 'table table-striped table-bordered'],
                'columns' => [
                    // ELIMINADO: ['class' => 'yii\grid\SerialColumn'],
                    
                    // ELIMINADO: Todo el bloque de tipo_documento
                    
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

<?php
// JavaScript para el filtro
$js = <<<JS
// Filtro por tipo de documento
$('#tipo-documento-filter').change(function() {
    var tipo = $(this).val();
    
    if (tipo) {
        window.location.search = '?tipo=' + encodeURIComponent(tipo);
    } else {
        window.location.search = '';
    }
});
JS;

$this->registerJs($js);
?>