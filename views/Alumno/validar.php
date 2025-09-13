<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Alumno $model */
/** @var app\models\Requisito[] $requisitos */
?>

<div class="requisito-validar">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-check-circle"></i> Validar Requisitos - <?= Html::encode($model->nombreCompleto) ?>
            </h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-arrow-left"></i> Volver', ['view', 'id' => $model->id], ['class' => 'btn btn-light btn-sm']) ?>
            </div>
        </div>
        <div class="card-body">
            <!-- CAMBIO IMPORTANTE: Agregar action y method al formulario -->
            <?php $form = ActiveForm::begin([
                'action' => ['gestionar-requisitos', 'id' => $model->id],
                'method' => 'post'
            ]); ?>
            
            <div class="alert alert-info">
                <strong><i class="fas fa-info-circle"></i> Información:</strong>
                Marque los requisitos que el alumno ha cumplido. Los requisitos obligatorios están resaltados.
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4 class="mb-3">Requisitos por Tipo de Documento</h4>
                    
                    <?php
                    $tiposDocumentos = \app\models\Requisito::getTiposDocumentos();
                    foreach ($tiposDocumentos as $tipoKey => $tipoNombre): 
                        $requisitosTipo = array_filter($requisitos, function($req) use ($tipoKey) {
                            return $req->tipo_documento === $tipoKey;
                        });
                        
                        if (!empty($requisitosTipo)):
                    ?>
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-alt"></i> <?= $tipoNombre ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="50px">Estado</th>
                                            <th>Requisito</th>
                                            <th>Descripción</th>
                                            <th width="100px">Obligatorio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($requisitosTipo as $requisito): 
                                            $avance = \app\models\AvanceAlumno::find()
                                                ->where([
                                                    'alumno_id' => $model->id,
                                                    'requisito_id' => $requisito->id
                                                ])
                                                ->one();
                                            $cumplido = $avance ? $avance->completado : 0;
                                        ?>
                                        <tr class="<?= $requisito->obligatorio ? 'table-warning' : '' ?>">
                                            <td class="text-center">
                                                <div class="form-check form-switch">
                                                    <?= Html::checkbox(
                                                        "requisitos[]", 
                                                        $cumplido, 
                                                        [
                                                            'value' => $requisito->id,
                                                            'class' => 'form-check-input requisito-checkbox',
                                                            'id' => 'requisito-' . $requisito->id
                                                        ]
                                                    ) ?>
                                                    <label class="form-check-label" for="requisito-<?= $requisito->id ?>">
                                                        <?php if ($cumplido): ?>
                                                            <span class="badge bg-success">✓</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">○</span>
                                                        <?php endif; ?>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <label for="requisito-<?= $requisito->id ?>" style="cursor: pointer;">
                                                    <strong><?= Html::encode($requisito->nombre) ?></strong>
                                                </label>
                                            </td>
                                            <td>
                                                <?php if ($requisito->descripcion): ?>
                                                    <small class="text-muted"><?= Html::encode($requisito->descripcion) ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted">Sin descripción</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($requisito->obligatorio): ?>
                                                    <span class="badge bg-warning">Sí</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info">No</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; endforeach; ?>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <?= Html::submitButton('<i class="fas fa-save"></i> Guardar Validación', [
                                    'class' => 'btn btn-success btn-lg btn-block',
                                    'name' => 'guardar', // Añadir name al botón
                                    'value' => '1'
                                ]) ?>
                            </div>
                            <div class="text-center">
                                <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['view', 'id' => $model->id], [
                                    'class' => 'btn btn-outline-secondary'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted">
                        <i class="fas fa-exclamation-triangle"></i> Los requisitos marcados en amarillo son obligatorios
                    </small>
                </div>
                <div class="col-md-6 text-right">
                    <small class="text-muted">
                        Última actualización: <?= date('d/m/Y H:i') ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.requisito-checkbox {
    transform: scale(1.5);
    cursor: pointer;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.badge {
    font-size: 0.85em;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}
</style>

<?php
// JavaScript para mejorar la experiencia de usuario
$this->registerJs(<<<JS
$(document).ready(function() {
    // Hacer que toda la fila sea clickeable para los checkboxes
    $('tr').click(function(e) {
        if (!$(e.target).is('a, button, .btn')) {
            var checkbox = $(this).find('.requisito-checkbox');
            if (checkbox.length) {
                checkbox.prop('checked', !checkbox.prop('checked'));
                // Actualizar el badge visual
                var badge = checkbox.closest('td').find('.badge');
                if (checkbox.prop('checked')) {
                    badge.removeClass('bg-secondary').addClass('bg-success').text('✓');
                } else {
                    badge.removeClass('bg-success').addClass('bg-secondary').text('○');
                }
            }
        }
    });

    // Contador de requisitos cumplidos
    function updateCounter() {
        var total = $('.requisito-checkbox').length;
        var completed = $('.requisito-checkbox:checked').length;
        $('#counter').text(completed + ' de ' + total + ' requisitos cumplidos');
    }

    // Inicializar contador
    updateCounter();

    // Actualizar contador cuando cambien los checkboxes
    $('.requisito-checkbox').change(updateCounter);
});
JS
);