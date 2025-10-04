<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Alumno $alumno */
/** @var app\models\Revisor[] $revisores */
/** @var array $revisoresAsignados */ // CAMBIADO: Ahora es un array de IDs

$this->title = 'Asignar Revisores: ' . $alumno->nombreCompleto;
$this->params['breadcrumbs'][] = ['label' => 'Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $alumno->nombreCompleto, 'url' => ['view', 'id' => $alumno->id]];
$this->params['breadcrumbs'][] = 'Asignar Revisores';

// URLs para JavaScript
$generarPdfUrl = Yii::$app->urlManager->createUrl(['alumno/generar-pdf']);
$csrfToken = Yii::$app->request->csrfToken;
?>

<div class="alumno-asignar-revisores">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-info">
                        <strong><i class="fas fa-info-circle"></i> Importante:</strong>
                        Debe seleccionar exactamente 4 revisores(min y max) para continuar con el proceso.
                    </div>
                    
                    <h4>Seleccionar Revisores</h4>
                    
                    <div class="form-group">
                        <label class="control-label">Revisores Disponibles</label>
                        <div class="revisores-list">
                            <?php 
                            // CAMBIADO: $revisoresAsignados ahora es un array de IDs, no de objetos
                            foreach ($revisores as $revisor): ?>
                                <div class="form-check revisores-checkbox">
                                    <?= Html::checkbox('revisores[]', 
                                        in_array($revisor->id, $revisoresAsignados), 
                                        [
                                            'value' => $revisor->id,
                                            'class' => 'form-check-input revisor-checkbox',
                                            'id' => 'revisor-' . $revisor->id
                                        ]) ?>
                                    <label class="form-check-label" for="revisor-<?= $revisor->id ?>">
                                        <strong><?= Html::encode($revisor->nombre) ?></strong>
                                        <br>
                                        <small class="text-muted"><?= Html::encode($revisor->cargo) ?></small>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="selected-count mt-2">
                            <span id="selected-count">0</span> de 4 revisores seleccionados
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">Acciones</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" id="btn-guardar">
                                    <i class="fas fa-save"></i> Guardar Asignación
                                </button>
                                
                                <button type="button" class="btn btn-success" id="btn-generar" 
                                        data-alumno-id="<?= $alumno->id ?>">
                                    <i class="fas fa-file-pdf"></i> Generar PDF
                                </button>
                                
                                <?= Html::a('Volver', ['view', 'id' => $alumno->id], [
                                    'class' => 'btn btn-secondary'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Modal para mostrar el PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="pdfModalLabel">
                    <i class="fas fa-file-pdf"></i> Documento Generado - Notificación al Alumno
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <a href="#" class="btn btn-primary" id="btn-descargar-modal">
                        <i class="fas fa-download"></i> Descargar PDF
                    </a>
                    <button type="button" class="btn btn-info" id="btn-refrescar">
                        <i class="fas fa-sync-alt"></i> Refrescar Vista
                    </button>
                </div>
                <div id="loading-pdf" class="text-center" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando PDF...</span>
                    </div>
                    <p>Cargando documento...</p>
                </div>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe id="pdf-viewer-modal" class="embed-responsive-item" 
                            style="width: 100%; height: 500px; border: 1px solid #ddd;" 
                            frameborder="0"></iframe>
                </div>
                <div id="pdf-error" class="alert alert-danger mt-3" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <span id="error-message"></span>
                </div>
                
                <!-- Sección para documentos adicionales -->
                <div id="documentos-adicionales" class="mt-4" style="display: none;">
                    <h6><i class="fas fa-file-alt"></i> Documentos Adicionales Generados:</h6>
                    <div class="row" id="lista-documentos">
                        <!-- Aquí se cargarán los documentos 001 -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<?php
// JavaScript para manejar la selección de revisores y generación de documentos
$this->registerJs(<<<JS
$(document).ready(function() {
    // URLs desde PHP
    const generarPdfUrl = '$generarPdfUrl';
    const csrfToken = '$csrfToken';
    
    // Inicializar modal de Bootstrap
    const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
    let currentDocumentData = null;

    // Contador de revisores seleccionados
    function updateSelectedCount() {
        const selected = $('.revisor-checkbox:checked').length;
        $('#selected-count').text(selected);
        
        // Habilitar/deshabilitar botones según la selección
        const btnGuardar = $('#btn-guardar');
        const btnGenerar = $('#btn-generar');
        
        if (selected === 4) {
            btnGuardar.prop('disabled', false);
            btnGenerar.prop('disabled', false);
        } else {
            btnGuardar.prop('disabled', true);
            btnGenerar.prop('disabled', true);
        }
    }
    
    // Inicializar contador
    updateSelectedCount();
    
    // Actualizar contador cuando cambia la selección
    $('.revisor-checkbox').change(updateSelectedCount);
    
    // Función para mostrar documentos en modal completo (como en view.php)
    // Función para mostrar documentos en modal completo
function mostrarModalDocumentosCompleto(response) {
    // Crear contenido del modal
    let modalContent = '<div class="modal fade" id="documentosModalCompleto" tabindex="-1" aria-labelledby="documentosModalCompletoLabel" aria-hidden="true">';
    modalContent += '<div class="modal-dialog modal-lg">';
    modalContent += '<div class="modal-content">';
    modalContent += '<div class="modal-header bg-success text-white">';
    modalContent += '<h5 class="modal-title" id="documentosModalCompletoLabel"><i class="fas fa-file-pdf"></i> Documentos Generados</h5>';
    modalContent += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
    modalContent += '</div>';
    modalContent += '<div class="modal-body">';
    
    // Documento 002 - Notificación al alumno
    if (response.documento002) {
        modalContent += '<div class="mb-4">';
        modalContent += '<h5><i class="fas fa-file-alt"></i> Documento 002 - Notificación al Alumno</h5>';
        modalContent += '<div class="d-flex gap-2 mt-2">';
        modalContent += '<a href="' + response.documento002.viewUrl + '" target="_blank" class="btn btn-outline-primary">';
        modalContent += '<i class="fas fa-eye"></i> Ver Documento';
        modalContent += '</a>';
        modalContent += '<a href="' + response.documento002.downloadUrl + '" class="btn btn-outline-success">';
        modalContent += '<i class="fas fa-download"></i> Descargar PDF';
        modalContent += '</a>';
        modalContent += '</div>';
        modalContent += '</div>';
    }
    
    // Documentos 001 - Cartas individuales
    if (response.documentos001 && response.documentos001.length > 0) {
        modalContent += '<div class="mb-3">';
        modalContent += '<h5><i class="fas fa-envelope"></i> Documentos 001 - Cartas para Revisores</h5>';
        
        response.documentos001.forEach(function(doc, index) {
            modalContent += '<div class="card mt-2">';
            modalContent += '<div class="card-body">';
            modalContent += '<h6 class="card-title">' + doc.revisorNombre + '</h6>';
            modalContent += '<div class="d-flex gap-2">';
            modalContent += '<a href="' + doc.viewUrl + '" target="_blank" class="btn btn-outline-primary btn-sm">';
            modalContent += '<i class="fas fa-eye"></i> Ver';
            modalContent += '</a>';
            modalContent += '<a href="' + doc.downloadUrl + '" class="btn btn-outline-success btn-sm">';
            modalContent += '<i class="fas fa-download"></i> Descargar';
            modalContent += '</a>';
            modalContent += '</div>';
            modalContent += '</div>';
            modalContent += '</div>';
        });
        
        modalContent += '</div>';
    }
    
    modalContent += '</div>';
    modalContent += '<div class="modal-footer">';
    modalContent += '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
    modalContent += '</div>';
    modalContent += '</div>';
    modalContent += '</div>';
    modalContent += '</div>';
    
    // Agregar el modal al DOM y mostrarlo
    $('body').append(modalContent);
    $('#documentosModalCompleto').modal('show');
    
    // Remover el modal cuando se cierre
    $('#documentosModalCompleto').on('hidden.bs.modal', function () {
        $(this).remove();
    });
}
    
    // Generar documentos y mostrar en modal
    $('#btn-generar').click(function() {
        if (!confirm('¿Generar documentos de revisores para este alumno?')) {
            return;
        }
        
        const btn = $(this);
        const originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Generando...');
        btn.prop('disabled', true);
        
        const alumnoId = btn.data('alumno-id');
        
        $.ajax({
            url: generarPdfUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                id: alumnoId,
                tipo_documento: 'revisores',
                _csrf: csrfToken
            },
            success: function(response) {
                console.log('Respuesta completa:', response);
                
                if (response.success) {
                    // Mostrar el modal completo con ambos documentos
                    mostrarModalDocumentosCompleto(response);
                } else {
                    // Mostrar error en el modal existente
                    $('#error-message').text(response.error || 'Error desconocido al generar el documento');
                    $('#pdf-error').show();
                    $('#loading-pdf').hide();
                    pdfModal.show();
                }
                
                btn.html(originalText);
                btn.prop('disabled', false);
            },
            error: function(xhr, status, error) {
                console.error('Error completo:', xhr.responseText);
                
                let errorMsg = 'Error al generar documento: ';
                
                if (xhr.status === 404) {
                    errorMsg += 'La acción no fue encontrada (404). Verifique las rutas.';
                } else if (xhr.status === 500) {
                    errorMsg += 'Error interno del servidor (500). Revise los logs.';
                } else {
                    errorMsg += xhr.statusText || 'Error de conexión';
                }
                
                // Mostrar error en el modal existente
                $('#error-message').text(errorMsg);
                $('#pdf-error').show();
                $('#loading-pdf').hide();
                pdfModal.show();
                
                btn.html(originalText);
                btn.prop('disabled', false);
            }
        });
    });
    
    // Limpiar cuando se cierra el modal
    $('#pdfModal').on('hidden.bs.modal', function () {
        $('#pdf-viewer-modal').attr('src', '');
        $('#pdf-error').hide();
        $('#documentos-adicionales').hide();
        currentDocumentData = null;
    });
    
    // Forzar descarga al hacer clic en el botón
    $('#btn-descargar-modal').click(function(e) {
        if (!currentDocumentData) {
            e.preventDefault();
            alert('No hay documento para descargar');
        }
    });
});
JS
);
?>

<!-- Incluir Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
.revisores-list {
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 5px;
}

.revisores-checkbox {
    padding: 10px;
    border-bottom: 1px solid #eee;
    margin-bottom: 5px;
}

.revisores-checkbox:last-child {
    border-bottom: none;
}

.revisores-checkbox:hover {
    background-color: #f8f9fa;
}

.selected-count {
    font-weight: bold;
    color: #0d6efd;
}

.modal-xl {
    max-width: 90%;
}

.embed-responsive {
    position: relative;
    display: block;
    width: 100%;
    padding: 0;
    overflow: hidden;
}

.embed-responsive-16by9::before {
    padding-top: 56.25%;
}

.embed-responsive-item {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

#loading-pdf {
    padding: 40px 0;
}

#lista-documentos .card {
    height: 100%;
}
</style>