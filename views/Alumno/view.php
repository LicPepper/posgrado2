<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Alumno $model */
/** @var bool $puedeGenerar */
?>

<div class="alumno-view">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Información del Alumno</h3>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'matricula',
                            'nombre',
                            'apellido_paterno',
                            'apellido_materno',
                            [
                                'attribute' => 'programa_id',
                                'value' => $model->programa->nombre ?? 'N/A',
                                'label' => 'Programa'
                            ],
                            'email:email',
                            'telefono',
                        ],
                        'options' => ['class' => 'table table-bordered']
                    ]) ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Requisitos Cumplidos</h3>
                </div>
                <div class="card-body">
                    <?php if (count($model->avanceAlumnos) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Requisito</th>
                                        <th>Estado</th>
                                        <th>Fecha Completado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($model->avanceAlumnos as $avance): ?>
                                    <tr>
                                        <td><?= Html::encode($avance->requisito->nombre) ?></td>
                                        <td>
                                            <?= $avance->completado ? 
                                                '<span class="badge bg-success">Completado</span>' : 
                                                '<span class="badge bg-secondary">Pendiente</span>' ?>
                                        </td>
                                        <td><?= $avance->fecha_completado ? Yii::$app->formatter->asDate($avance->fecha_completado) : '--' ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            No se han registrado requisitos para este alumno.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Acciones</h3>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary w-100 mb-3" 
                            data-bs-toggle="modal" 
                            data-bs-target="#generarDocumentoModal"
                            <?= !$puedeGenerar ? 'disabled' : '' ?>>
                        <i class="fas fa-file-pdf"></i> Generar Documento
                    </button>

                    <?= Html::a('<i class="fas fa-check-circle"></i> Validar Requisitos', 
                        ['validar', 'id' => $model->id], 
                        ['class' => 'btn btn-outline-primary w-100 mb-3']
                    ) ?>

                    <?= Html::a('<i class="fas fa-edit"></i> Editar Datos', 
                        ['update', 'id' => $model->id], 
                        ['class' => 'btn btn-outline-secondary w-100 mb-3']
                    ) ?>

                    <?= Html::a('<i class="fas fa-history"></i> Ver Historial', 
                        ['documento-generado/ver-historia', 'alumno_id' => $model->id], 
                        ['class' => 'btn btn-outline-info w-100']
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para selección de documento -->
<?php Modal::begin([
    'id' => 'generarDocumentoModal',
    'title' => 'Generar Documento para '.Html::encode($model->nombreCompleto),
    'size' => 'modal-lg'
]) ?>

<?php $form = ActiveForm::begin([
    'id' => 'documento-form',
    'action' => ['documento-generado/generar'],
]) ?>

<input type="hidden" name="alumno_id" value="<?= $model->id ?>">

<div class="mb-3">
    <label class="form-label">Tipo de documento:</label>
    <select name="tipo_documento" class="form-select" id="tipo-documento" required>
        <option value="">-- Seleccione --</option>
        <option value="Constancia">Constancia General</option>
        <option value="Kardex">Kardex</option>
        
        <?php if ($model->programa && $model->programa->nivel === 'Maestría'): ?>
            <option value="LiberacionIngles">Liberación de Inglés</option>
            <option value="LiberacionTesis">Liberación de Tesis</option>
        <?php endif; ?>
        
        <option value="Estancia">Carta de Estancia</option>
    </select>
</div>

<div id="campos-dinamicos">
    <!-- Campos adicionales se cargarán aquí -->
</div>

<div class="text-end mt-3">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary">Generar</button>
</div>

<?php ActiveForm::end() ?>

<?php Modal::end() ?>

<!-- Modal para visualización de PDF -->
<?php Modal::begin([
    'id' => 'pdfModal',
    'title' => 'Documento Generado',
    'size' => 'modal-lg',
    'options' => ['class' => 'fade'],
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false
    ]
]) ?>
<div class="modal-body">
    <!-- Contenido cargado dinámicamente -->
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>
<?php Modal::end() ?>

<!-- Modal para errores -->
<?php Modal::begin([
    'id' => 'errorModal',
    'title' => 'Error',
    'size' => 'modal-lg',
]) ?>
<div class="modal-body">
    <!-- El contenido del error se insertará aquí -->
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>
<?php Modal::end() ?>

<?php
$js = <<<JS
// Debug inicial
console.log("Script cargado correctamente");

// Manejar campos dinámicos
$('#tipo-documento').on('change', function() {
    console.log("Tipo de documento cambiado:", this.value);
    
    const container = $('#campos-dinamicos');
    const tipo = $(this).val();
    
    let html = '';
    
    switch(tipo) {
        case 'LiberacionIngles':
            html = `
                <div class="mb-3">
                    <label class="form-label">Título del artículo en inglés:</label>
                    <input type="text" name="articulo" class="form-control" required 
                           placeholder="Ingrese el título completo del artículo">
                </div>
            `;
            break;
            
        case 'Estancia':
            const fechaActual = new Date().toISOString().split('T')[0];
            const fechaFin = new Date();
            fechaFin.setMonth(fechaFin.getMonth() + 1);
            const fechaFinStr = fechaFin.toISOString().split('T')[0];
            
            html = `
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha de inicio:</label>
                        <input type="date" name="fecha_inicio" class="form-control" 
                               value="\${fechaActual}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha de fin:</label>
                        <input type="date" name="fecha_fin" class="form-control" 
                               value="\${fechaFinStr}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre del asesor:</label>
                    <input type="text" name="asesor" class="form-control" 
                           value="MCIB. Juana Selvan García" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Título del proyecto:</label>
                    <input type="text" name="proyecto" class="form-control" 
                           value="Tesis de {$model->programa->nombre}" required>
                </div>
            `;
            break;
            
        default:
            html = '';
            break;
    }
    
    container.html(html);
    console.log("HTML generado:", html);
});

// Manejar envío del formulario
$('#documento-form').on('submit', function(e) {
    e.preventDefault();
    console.log("Formulario enviado");
    
    const btn = $(this).find('[type="submit"]');
    const originalText = btn.html();
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Generando...');
    
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            console.log("Respuesta recibida:", response);
            
            if (response && response.success) {
                $('#generarDocumentoModal').modal('hide');
                if (response.pdfUrl) {
                    $('#pdfModal .modal-body').html(`
                        <iframe src="\${response.pdfUrl}" style="width:100%; height:70vh; border:none;"></iframe>
                        <div class="text-center mt-3">
                            <a href="\${response.downloadUrl}" class="btn btn-primary me-2">
                                <i class="fas fa-download"></i> Descargar PDF
                            </a>
                            <a href="\${response.historialUrl}" class="btn btn-info">
                                <i class="fas fa-history"></i> Ver Historial
                            </a>
                        </div>
                    `);
                    $('#pdfModal').modal('show');
                }
            } else {
                let errorMsg = 'Error al generar documento';
                if (response && response.error) {
                    errorMsg = response.error;
                }
                
                $('#errorModal .modal-body').html(errorMsg);
                $('#errorModal').modal('show');
                
                if (response && response.technical) {
                    console.error("Detalles técnicos:", response.technical);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la petición:", status, error, xhr.responseText);
            
            let errorMsg = 'Error de comunicación con el servidor: ' + error;
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMsg = xhr.responseJSON.error;
            } else if (xhr.responseText) {
                try {
                    const resp = JSON.parse(xhr.responseText);
                    errorMsg = resp.error || errorMsg;
                } catch (e) {
                    errorMsg = xhr.responseText;
                }
            }
            
            $('#errorModal .modal-body').html(errorMsg);
            $('#errorModal').modal('show');
        },
        complete: function() {
            btn.prop('disabled', false).html(originalText);
        }
    });
});

// Mostrar tooltip si el botón está deshabilitado
$('[data-bs-target="#generarDocumentoModal"][disabled]').tooltip({
    title: 'No se pueden generar documentos. Faltan requisitos obligatorios.',
    placement: 'top'
});

// Debug final
console.log("Eventos registrados correctamente");
JS;

$this->registerJs($js);
?>

<style>
.alumno-view {
    padding: 20px;
}
.card {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.card-header {
    padding: 0.75rem 1.25rem;
    border-bottom: 1px solid rgba(0,0,0,.05);
}
.table th {
    font-weight: 600;
}
.btn {
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}
.btn:hover {
    transform: translateY(-2px);
}
.badge {
    font-size: 0.85em;
    font-weight: 500;
}
.modal-body iframe {
    min-height: 70vh;
}
</style>