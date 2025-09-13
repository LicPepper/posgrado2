<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Alumno $alumno */
/** @var app\models\DocumentoGenerado[] $documentos */

$this->title = 'Historial de Documentos: ' . $alumno->nombreCompleto;
$this->params['breadcrumbs'][] = ['label' => 'Alumnos', 'url' => ['/alumno/index']];
$this->params['breadcrumbs'][] = ['label' => $alumno->nombreCompleto, 'url' => ['/alumno/view', 'id' => $alumno->id]];
$this->params['breadcrumbs'][] = 'Historial';
?>
<div class="HistorialDocumentos">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="card-title mb-0">
                <i class="fas fa-history"></i> <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <div class="card-body">
            
            <?= Html::beginForm(['bulk-delete'], 'post'); ?>
            
            <?= Html::hiddenInput('alumno_id', $alumno->id) ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 5%;" class="text-center">
                                <input type="checkbox" id="selectAllCheckbox">
                            </th>
                            <th>Tipo de Documento</th>
                            <th>Fecha de Generación</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($documentos)): ?>
                            <?php foreach ($documentos as $documento): ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selection[]" value="<?= $documento->id ?>" class="doc-checkbox">
                                </td>
                                <td><?= Html::encode($documento->plantilla->nombre ?? 'N/A') ?></td>
                                <td><?= Yii::$app->formatter->asDatetime($documento->fecha_generacion, 'long') ?></td>
                                <td>
                                    <span class="badge badge-info"><?= $documento->estado ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Acciones de documento">
                                        <?= Html::a('<i class="fas fa-eye"></i>', ['view-pdf', 'id' => $documento->id], ['class' => 'btn btn-sm btn-outline-info', 'target' => '_blank', 'data-toggle' => 'tooltip', 'title' => 'Ver Documento']) ?>
                                        <?= Html::a('<i class="fas fa-download"></i>', ['download', 'id' => $documento->id], ['class' => 'btn btn-sm btn-outline-success', 'data-toggle' => 'tooltip', 'title' => 'Descargar']) ?>
                                        <?= Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $documento->id], ['class' => 'btn btn-sm btn-outline-danger', 'data' => ['confirm' => '¿Estás seguro de que deseas eliminar este documento?', 'method' => 'post'], 'data-toggle' => 'tooltip', 'title' => 'Eliminar']) ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-info mt-3 mb-0">
                                        <i class="fas fa-info-circle"></i> No se han generado documentos para este alumno.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (!empty($documentos)): ?>
                <?= Html::submitButton('<i class="fas fa-trash-alt"></i> Eliminar Seleccionados', [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => '¿Estás seguro de que deseas eliminar TODOS los documentos seleccionados? Esta acción es irreversible.',
                    ],
                ]) ?>
            <?php endif; ?>

            <?= Html::endForm(); ?>
            </div>
    </div>
</div>

<?php
// Script para activar los tooltips y la funcionalidad de "Seleccionar Todos"
$js = <<<JS
$(function () {
  // Activar tooltips de Bootstrap
  $('[data-toggle="tooltip"]').tooltip();

  // Lógica para el checkbox "Seleccionar Todos"
  $('#selectAllCheckbox').on('click', function() {
    $('.doc-checkbox').prop('checked', $(this).prop('checked'));
  });

  // Si se desmarca un checkbox individual, desmarcar el "Seleccionar Todos"
  $('.doc-checkbox').on('click', function() {
    if (!$(this).prop('checked')) {
      $('#selectAllCheckbox').prop('checked', false);
    }
  });
});
JS;
$this->registerJs($js);
?>