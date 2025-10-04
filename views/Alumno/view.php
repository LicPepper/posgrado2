<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Alumno $model */
/** @var bool $puedeGenerar */

// Obtener el título de tesis para usar en JavaScript
$tituloTesis = !empty($model->titulo_tesis) ? $model->titulo_tesis : '';

// Verificar requisitos para cada tipo de documento
$requisitosPorTipo = [];
$tiposDocumentos = \app\models\Requisito::getTiposDocumentos();

foreach ($tiposDocumentos as $tipoKey => $tipoNombre) {
    $requisitos = \app\models\Requisito::getRequisitosPorTipo($tipoKey);
    $requisitosPorTipo[$tipoKey] = [
        'nombre' => $tipoNombre,
        'cumplido' => true // Asumimos que se cumplen inicialmente
    ];
    
    foreach ($requisitos as $requisito) {
        if ($requisito->obligatorio) {
            $avance = \app\models\AvanceAlumno::find()
                ->where([
                    'alumno_id' => $model->id,
                    'requisito_id' => $requisito->id,
                    'completado' => 1
                ])
                ->exists();
            
            if (!$avance) {
                $requisitosPorTipo[$tipoKey]['cumplido'] = false;
                break; // No need to check further if one is missing
            }
        }
    }
}

// Filtrar solo los documentos disponibles
$documentosDisponibles = array_filter($requisitosPorTipo, function($doc) {
    return $doc['cumplido'];
});

// Convertir a JSON para usar en JavaScript
$requisitosJson = json_encode($requisitosPorTipo);
$documentosDisponiblesJson = json_encode(array_keys($documentosDisponibles));
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
                            [
                                'attribute' => 'titulo_tesis',
                                'label' => 'Título de Tesis'
                            ],
                        ],
                        'options' => ['class' => 'table table-bordered']
                    ]) ?>
                </div>
            </div>

            <!-- Estado de Requisitos por Tipo de Documento -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list-check"></i> Estado de Requisitos por Documento
                    </h3>
                </div>
                <div class="card-body">
                    <?php foreach ($requisitosPorTipo as $tipoKey => $info): 
                        $requisitos = \app\models\Requisito::getRequisitosPorTipo($tipoKey);
                        if (!empty($requisitos)):
                    ?>
                    <div class="mb-3">
                        <h5>
                            <?= $info['nombre'] ?>
                            <?php if ($info['cumplido']): ?>
                                <span class="badge bg-success float-end">Disponible</span>
                            <?php else: ?>
                                <span class="badge bg-warning float-end">Pendiente</span>
                            <?php endif; ?>
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Requisito</th>
                                        <th width="100px">Estado</th>
                                        <th width="120px">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($requisitos as $requisito): 
                                        $avance = \app\models\AvanceAlumno::find()
                                            ->where([
                                                'alumno_id' => $model->id,
                                                'requisito_id' => $requisito->id
                                            ])
                                            ->one();
                                        $cumplido = $avance && $avance->completado;
                                    ?>
                                    <tr>
                                        <td>
                                            <?= Html::encode($requisito->nombre) ?>
                                            <?php if ($requisito->descripcion): ?>
                                                <br><small class="text-muted"><?= Html::encode($requisito->descripcion) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= $cumplido ? 'success' : 'warning' ?>">
                                                <?= $cumplido ? '✓ Cumplido' : 'Pendiente' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= $cumplido && $avance->fecha_completado ? 
                                                Yii::$app->formatter->asDate($avance->fecha_completado) : '--' ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; endforeach; ?>
                </div>
            </div>

            <!-- Sección de Revisores Asignados -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Revisores Asignados</h3>
                </div>
                <div class="card-body">
                    <?php 
                    $revisoresAsignados = $model->revisores;
                    if (count($revisoresAsignados) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre del Revisor</th>
                                        <th>Cargo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($revisoresAsignados as $index => $revisor): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= Html::encode($revisor->nombre) ?></td>
                                        <td><?= Html::encode($revisor->cargo) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            No se han asignado revisores para este alumno.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SECCIÓN PARA MOSTRAR DOCUMENTOS GENERADOS (AJAX) -->
            <div class="card mt-4" id="documentos-generados-container" style="display: none;">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">
                        <i class="fas fa-file-pdf"></i> Documentos Generados
                    </h3>
                </div>
                <div class="card-body" id="documentos-content">
                    <!-- Aquí se mostrarán los documentos via AJAX -->
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Acciones</h3>
                </div>
                <div class="card-body">
                    <!-- Botón para asignar revisores -->
                    <?= Html::a(
                        '<i class="fas fa-user-plus"></i> Asignar Revisores',
                        ['asignar-revisores', 'id' => $model->id],
                        ['class' => 'btn btn-info w-100 mb-3']
                    ) ?>

                    <!-- Botón para generar documentos (existente) -->
                    <button class="btn btn-primary w-100 mb-3" 
                            data-bs-toggle="modal" 
                            data-bs-target="#generarDocumentoModal"
                            id="btn-generar-documento">
                        <i class="fas fa-file-pdf"></i> Generar Documento
                    </button>

                    <?= Html::a(
                        '<i class="fas fa-check-circle"></i> Validar Requisitos', 
                        ['validar-requisitos', 'id' => $model->id], 
                        ['class' => 'btn btn-outline-primary w-100 mb-3']
                    ) ?>

                    <?= Html::a(
                        '<i class="fas fa-edit"></i> Editar Datos', 
                        ['update', 'id' => $model->id], 
                        ['class' => 'btn btn-outline-secondary w-100 mb-3']
                    ) ?>

                    <?= Html::a(
                        '<i class="fas fa-history"></i> Ver Historial', 
                        ['documento-generado/ver-historia', 'alumno_id' => $model->id], 
                        ['class' => 'btn btn-outline-info w-100']
                    ) ?>
                </div>
            </div>

            <!-- Información de revisores -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Información de Revisores</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong><i class="fas fa-info-circle"></i> Importante:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Se requieren exactamente 4 revisores por alumno</li>
                            <li>Los documentos generados son:
                                <ul>
                                    <li><strong>*</strong> Cartas individuales para cada revisor</li>
                                    <li><strong>*</strong> Notificación de asignación al alumno</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Información de requisitos -->
            <div class="card mt-4">
                <div class="card-header bg-warning text-dark">
                    <h3 class="card-title">Información de Requisitos</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong><i class="fas fa-exclamation-triangle"></i> Requisitos:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Los requisitos se validan por tipo de documento</li>
                            <li>Use "Validar Requisitos" para marcar cumplimiento</li>
                            <li>Los documentos solo se generan si todos los requisitos están cumplidos</li>
                            <li>El botón "Generar Documento" estará disponible cuando al menos un tipo de documento tenga todos sus requisitos cumplidos</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para generación de documentos (existente) -->
<?php Modal::begin([
    'id' => 'generarDocumentoModal',
    'title' => 'Generar Documento para ' . Html::encode($model->nombreCompleto),
    'size' => 'modal-lg'
]) ?>

<div class="modal-body">
    <?php $form = ActiveForm::begin([
        'id' => 'generar-documento-form',
        'action' => ['/documento-generado/generar'],
        'method' => 'post'
    ]); ?>

    <?= Html::hiddenInput('alumno_id', $model->id) ?>

    <div class="form-group">
        <label for="tipo-documento">Tipo de Documento</label>
        <select class="form-control" id="tipo-documento" name="tipo_documento" required>
            <option value="">Seleccionar tipo de documento</option>
            <!-- Las opciones se llenarán dinámicamente con JavaScript -->
        </select>
        <small class="form-text text-muted">
            Seleccione el tipo de documento a generar
        </small>
    </div>

    <div id="campos-dinamicos">
        <!-- Los campos dinámicos se cargarán aquí mediante JavaScript -->
    </div>

    <div id="sin-documentos-alerta" class="alert alert-info" style="display: none;">
        <i class="fas fa-info-circle"></i> 
        <span>No hay documentos disponibles para generar. Complete los requisitos necesarios.</span>
    </div>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary" id="btn-generar-submit" disabled>
            <i class="fas fa-file-pdf"></i> Generar Documento
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cancelar
        </button>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php Modal::end() ?>

<?php
$js = <<<JS
// Datos de requisitos por tipo de documento
var requisitosPorTipo = $requisitosJson;
var documentosDisponibles = $documentosDisponiblesJson;

// Función para verificar si un tipo de documento tiene todos los requisitos cumplidos
function documentoDisponible(tipo) {
    return requisitosPorTipo[tipo] && requisitosPorTipo[tipo].cumplido;
}

// Función para llenar el dropdown con solo los documentos disponibles
function llenarDropdownDocumentos() {
    var dropdown = $('#tipo-documento');
    dropdown.empty().append('<option value="">Seleccionar tipo de documento</option>');
    
    var tieneDocumentos = false;
    
    // Documentos principales
    if (documentoDisponible('LiberacionIngles')) {
        dropdown.append('<option value="LiberacionIngles">Liberación de Inglés</option>');
        tieneDocumentos = true;
    }
    if (documentoDisponible('LiberacionTesis')) {
        dropdown.append('<option value="LiberacionTesis">Liberación de Tesis</option>');
        tieneDocumentos = true;
    }
    
    // Nuevos documentos oficiales
    if (documentoDisponible('AutorizacionImpresion')) {
        dropdown.append('<option value="AutorizacionImpresion">Autorización de Impresión de Tesis</option>');
        tieneDocumentos = true;
    }
    if (documentoDisponible('AutorizacionActoRecepcion')) {
        dropdown.append('<option value="AutorizacionActoRecepcion">Autorización de Acto de Recepción</option>');
        tieneDocumentos = true;
    }
    if (documentoDisponible('ConstanciaDictamen')) {
        dropdown.append('<option value="ConstanciaDictamen">Constancia de Dictamen de Tesis</option>');
        tieneDocumentos = true;
    }
    if (documentoDisponible('AutorizacionExamen')) {
        dropdown.append('<option value="AutorizacionExamen">Autorización de Examen</option>');
        tieneDocumentos = true;
    }
    if (documentoDisponible('ProtocoloExamen')) {
        dropdown.append('<option value="ProtocoloExamen">Protocolo de Examen Profesional</option>');
        tieneDocumentos = true;
    }
    
    // Documentos de revisores (si aplican)
    if (documentoDisponible('revisores')) {
        dropdown.append('<option value="revisores">Documentos de Revisores (Cartas + Notificación)</option>');
        tieneDocumentos = true;
    }
    
    // Mostrar mensaje si no hay documentos disponibles
    if (!tieneDocumentos) {
        $('#sin-documentos-alerta').show();
        $('#btn-generar-submit').prop('disabled', true);
    } else {
        $('#sin-documentos-alerta').hide();
    }
}

// Función para mostrar el PDF en un modal después de generarlo
function mostrarPDFenModal(response) {
    if (response.success) {
        // Crear modal para mostrar el PDF
        var modalHTML = '\
        <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">\
            <div class="modal-dialog modal-xl">\
                <div class="modal-content">\
                    <div class="modal-header bg-primary text-white">\
                        <h5 class="modal-title" id="pdfModalLabel">Documento Generado</h5>\
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\
                    </div>\
                    <div class="modal-body">\
                        <div class="text-center mb-3">\
                            <a href="' + response.downloadUrl + '" class="btn btn-success me-2" target="_blank">\
                                <i class="fas fa-download"></i> Descargar PDF\
                            </a>\
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">\
                                <i class="fas fa-times"></i> Cerrar\
                            </button>\
                        </div>\
                        <iframe src="' + response.pdfUrl + '" width="100%" height="600px" style="border: 1px solid #ddd;"></iframe>\
                    </div>\
                </div>\
            </div>\
        </div>';
        
        // Agregar el modal al DOM
        $('body').append(modalHTML);
        
        // Mostrar el modal
        $('#pdfModal').modal('show');
        
        // Eliminar el modal cuando se cierre
        $('#pdfModal').on('hidden.bs.modal', function () {
            $(this).remove();
        });
    }
}

// Verificar si hay al menos un documento disponible
function verificarDocumentosDisponibles() {
    var disponible = false;
    for (var tipo in requisitosPorTipo) {
        if (requisitosPorTipo[tipo].cumplido) {
            disponible = true;
            break;
        }
    }
    
    var btn = $('#btn-generar-documento');
    if (disponible) {
        btn.prop('disabled', false);
        btn.removeClass('btn-secondary').addClass('btn-primary');
    } else {
        btn.prop('disabled', true);
        btn.removeClass('btn-primary').addClass('btn-secondary');
    }
}

// Manejar el envío del formulario de generación de documentos
$('#generar-documento-form').on('submit', function(e) {
    e.preventDefault();
    
    var tipoDocumento = $('#tipo-documento').val();
    
    if (!tipoDocumento) {
        Swal.fire({
            icon: 'warning',
            title: 'Seleccione un documento',
            text: 'Por favor seleccione un tipo de documento para generar.',
            confirmButtonText: 'Entendido'
        });
        return false;
    }
    
    if (!documentoDisponible(tipoDocumento)) {
        Swal.fire({
            icon: 'warning',
            title: 'Requisitos pendientes',
            html: 'No cumple con todos los requisitos para generar este documento.',
            confirmButtonText: 'Entendido'
        });
        return false;
    }
    
    var form = $(this);
    var btn = form.find('button[type="submit"]');
    var originalText = btn.html();
    
    btn.html('<i class="fas fa-spinner fa-spin"></i> Generando...');
    btn.prop('disabled', true);
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
            btn.html(originalText);
            btn.prop('disabled', false);
            
            if (response.success) {
                // Cerrar el modal de generación
                $('#generarDocumentoModal').modal('hide');
                
                // Mostrar el PDF en un modal
                mostrarPDFenModal(response);
                
            } else {
                // Mostrar mensaje de error específico
                let errorMsg = response.error || 'Error al generar el documento';
                
                // Si es error de requisitos, mostrar de manera especial
                if (errorMsg.includes('Requisitos')) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Requisitos pendientes',
                        html: '<div class="text-left">' + errorMsg + '</div>',
                        confirmButtonText: 'Entendido'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg
                    });
                }
            }
        },
        error: function(xhr) {
            btn.html(originalText);
            btn.prop('disabled', false);
            
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor. Status: ' + xhr.status
            });
        }
    });
});

// Manejar cambio en el tipo de documento
$('#tipo-documento').change(function() {
    var tipo = $(this).val();
    var camposDiv = $('#campos-dinamicos');
    var btnSubmit = $('#btn-generar-submit');
    
    camposDiv.empty();
    
    if (!tipo) {
        btnSubmit.prop('disabled', true);
        return;
    }
    
    // Habilitar el botón de submit
    btnSubmit.prop('disabled', false);
    
    switch(tipo) {
        case 'LiberacionIngles':
            camposDiv.html('\
                <div class="form-group">\
                    <label for="articulo">Título del Artículo</label>\
                    <input type="text" class="form-control" id="articulo" name="articulo" required>\
                    <small class="form-text text-muted">Ingrese el título del artículo en inglés</small>\
                </div>\
            ');
            break;
            
        case 'LiberacionTesis':
            camposDiv.html('\
                <div class="form-group">\
                    <label for="titulo_tesis">Título de Tesis</label>\
                    <textarea class="form-control" id="titulo_tesis" name="titulo_tesis" rows="3" required>$tituloTesis</textarea>\
                    <small class="form-text text-muted">Ingrese el título completo de la tesis</small>\
                </div>\
                <div class="form-group">\
                    <label for="lgac_tesis">LGAC</label>\
                    <input type="text" class="form-control" id="lgac_tesis" name="lgac_tesis" value="Calidad y Sustentabilidad en las Organizaciones" required>\
                    <small class="form-text text-muted">Ingrese la LGAC correspondiente</small>\
                </div>\
                <div class="form-group">\
                    <label for="porcentaje_coincidencia">Porcentaje de Coincidencia Turnitin</label>\
                    <input type="number" class="form-control" id="porcentaje_coincidencia" name="porcentaje_coincidencia" min="0" max="100" value="10" required>\
                    <small class="form-text text-muted">Ingrese el porcentaje de coincidencia reportado por Turnitin</small>\
                </div>\
            ');
            break;
            
        case 'AutorizacionExamen':
            camposDiv.html('\
                <div class="form-group">\
                    <label for="titulo_tesis">Título de Tesis</label>\
                    <textarea class="form-control" id="titulo_tesis" name="titulo_tesis" rows="3" required>$tituloTesis</textarea>\
                    <small class="form-text text-muted">Ingrese el título completo de la tesis</small>\
                </div>\
                <div class="row">\
                    <div class="col-md-6">\
                        <div class="form-group">\
                            <label for="fecha_examen">Fecha del Examen</label>\
                            <input type="date" class="form-control" id="fecha_examen" name="fecha_examen" required>\
                        </div>\
                    </div>\
                    <div class="col-md-6">\
                        <div class="form-group">\
                            <label for="hora_examen">Hora del Examen</label>\
                            <input type="time" class="form-control" id="hora_examen" name="hora_examen" value="10:00" required>\
                        </div>\
                    </div>\
                </div>\
            ');
            break;
            
        case 'ConstanciaDictamen':
            camposDiv.html('\
                <div class="form-group">\
                    <label for="titulo_tesis">Título de Tesis</label>\
                    <textarea class="form-control" id="titulo_tesis" name="titulo_tesis" rows="3" required>$tituloTesis</textarea>\
                    <small class="form-text text-muted">Ingrese el título completo de la tesis</small>\
                </div>\
                <div class="form-group">\
                    <label for="lgac_tesis">LGAC</label>\
                    <input type="text" class="form-control" id="lgac_tesis" name="lgac_tesis" value="Calidad y Sustentabilidad en las Organizaciones">\
                    <small class="form-text text-muted">Ingrese la LGAC correspondiente</small>\
                </div>\
            ');
            break;
            
        case 'AutorizacionActoRecepcion':
            camposDiv.html('\
                <div class="form-group">\
                    <label for="titulo_tesis">Título de Tesis</label>\
                    <textarea class="form-control" id="titulo_tesis" name="titulo_tesis" rows="3" required>$tituloTesis</textarea>\
                    <small class="form-text text-muted">Ingrese el título completo de la tesis</small>\
                </div>\
                <div class="form-group">\
                    <label for="tipo_revisor">Tipo de Revisor</label>\
                    <select class="form-control" id="tipo_revisor" name="tipo_revisor" required>\
                        <option value="PRESIDENTE">Presidente</option>\
                        <option value="SECRETARIO">Secretario</option>\
                        <option value="VOCAL">Vocal</option>\
                    </select>\
                    <small class="form-text text-muted">Seleccione el tipo de revisor</small>\
                </div>\
                <div class="row">\
                    <div class="col-md-6">\
                        <div class="form-group">\
                            <label for="fecha_acto">Fecha del Acto</label>\
                            <input type="date" class="form-control" id="fecha_acto" name="fecha_acto" required>\
                        </div>\
                    </div>\
                    <div class="col-md-6">\
                        <div class="form-group">\
                            <label for="hora_acto">Hora del Acto</label>\
                            <input type="time" class="form-control" id="hora_acto" name="hora_acto" value="10:00" required>\
                        </div>\
                    </div>\
                </div>\
            ');
            break;
            
        case 'ProtocoloExamen':
            camposDiv.html('\
                <div class="form-group">\
                    <label for="titulo_tesis">Título de Tesis</label>\
                    <textarea class="form-control" id="titulo_tesis" name="titulo_tesis" rows="3" required>$tituloTesis</textarea>\
                    <small class="form-text text-muted">Ingrese el título completo de la tesis</small>\
                </div>\
                <div class="row">\
                    <div class="col-md-6">\
                        <div class="form-group">\
                            <label for="fecha_examen">Fecha del Examen</label>\
                            <input type="date" class="form-control" id="fecha_examen" name="fecha_examen" required>\
                        </div>\
                    </div>\
                    <div class="col-md-6">\
                        <div class="form-group">\
                            <label for="hora_examen">Hora del Examen</label>\
                            <input type="time" class="form-control" id="hora_examen" name="hora_examen" value="10:00" required>\
                        </div>\
                    </div>\
                </div>\
                <div class="form-group">\
                    <label for="presidente">Presidente del Jurado</label>\
                    <input type="text" class="form-control" id="presidente" name="presidente" required>\
                    <small class="form-text text-muted">Nombre completo del presidente del jurado</small>\
                </div>\
                <div class="form-group">\
                    <label for="secretario">Secretario del Jurado</label>\
                    <input type="text" class="form-control" id="secretario" name="secretario" required>\
                    <small class="form-text text-muted">Nombre completo del secretario del jurado</small>\
                </div>\
                <div class="form-group">\
                    <label for="vocal">Vocal del Jurado</label>\
                    <input type="text" class="form-control" id="vocal" name="vocal" required>\
                    <small class="form-text text-muted">Nombre completo del vocal del jurado</small>\
                </div>\
                <div class="form-group">\
                    <label for="vocal_suplente">Vocal Suplente (Opcional)</label>\
                    <input type="text" class="form-control" id="vocal_suplente" name="vocal_suplente">\
                    <small class="form-text text-muted">Nombre completo del vocal suplente (opcional)</small>\
                </div>\
            ');
            break;
            
        case 'revisores':
            camposDiv.html('\
                <div class="alert alert-info">\
                    <i class="fas fa-info-circle"></i> Se generarán 4 cartas individuales para revisores + 1 notificación al alumno\
                </div>\
            ');
            break;
            
        default:
            camposDiv.html('\
                <div class="alert alert-info">\
                    <i class="fas fa-info-circle"></i> No se requieren datos adicionales para este documento\
                </div>\
            ');
    }
});

// Inicializar la verificación de documentos disponibles
$(document).ready(function() {
    verificarDocumentosDisponibles();
    llenarDropdownDocumentos();
    console.log('Página cargada correctamente');
    
    // Cuando se abre el modal, asegurarse de que el dropdown esté actualizado
    $('#generarDocumentoModal').on('show.bs.modal', function () {
        llenarDropdownDocumentos();
    });
});
JS;

// Registrar el JavaScript en el head para que esté disponible cuando se haga clic en el botón
$this->registerJs($js, \yii\web\View::POS_END);
?>