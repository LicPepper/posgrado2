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
                    <?php
                    $tiposDocumentos = \app\models\Requisito::getTiposDocumentos();
                    foreach ($tiposDocumentos as $tipoKey => $tipoNombre): 
                        $requisitos = \app\models\Requisito::getRequisitosPorTipo($tipoKey);
                        if (!empty($requisitos)):
                    ?>
                    <div class="mb-3">
                        <h5><?= $tipoNombre ?></h5>
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
                            <?= !$puedeGenerar ? 'disabled' : '' ?>>
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



<?= Html::a(
    '<i class="fas fa-file-certificate"></i> Generar Constancia',
    ['generar-constancia', 'id' => $model->id],
    [
        'class' => 'btn btn-success w-100 mb-3',
        'data' => [
            'confirm' => '¿Generar constancia para ' . $model->nombre . '?',
            'method' => 'post',
        ]
    ]
) ?>


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
                                    <li><strong>001:</strong> Cartas individuales para cada revisor</li>
                                    <li><strong>002:</strong> Notificación de asignación al alumno</li>
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
            <?php
            $tiposDocumentos = \app\models\Requisito::getTiposDocumentos();
            foreach ($tiposDocumentos as $tipoKey => $tipoNombre): 
                // Verificar si el alumno cumple con los requisitos de este tipo
                $requisitos = \app\models\Requisito::getRequisitosPorTipo($tipoKey);
                $todosCumplidos = true;
                
                foreach ($requisitos as $requisito) {
                    $cumplido = \app\models\AvanceAlumno::find()
                        ->where([
                            'alumno_id' => $model->id,
                            'requisito_id' => $requisito->id,
                            'completado' => 1
                        ])
                        ->exists();
                    
                    if (!$cumplido) {
                        $todosCumplidos = false;
                        break;
                    }
                }
            ?>
            <option value="<?= $tipoKey ?>" <?= $todosCumplidos ? '' : 'disabled' ?>>
                <?= $tipoNombre ?> <?= $todosCumplidos ? '' : '(Faltan requisitos)' ?>
            </option>
            <?php endforeach; ?>
        </select>
        <small class="form-text text-muted">
            Solo se muestran los documentos para los que el alumno cumple con todos los requisitos
        </small>
    </div>

    <div id="campos-dinamicos">
        <!-- Los campos dinámicos se cargarán aquí mediante JavaScript -->
    </div>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">
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
$urlGenerarPdf = Url::to(['alumno/generar-pdf']);
$js = <<<JS
// Función principal para generar documentos
function generarDocumentosRevisores(alumnoId) {
    console.log('Iniciando generación de documentos para alumno:', alumnoId);
    
    if (!confirm('¿Generar documentos de revisores para este alumno?')) {
        return false;
    }
    
    // Mostrar loading
    const btn = document.getElementById('btn-generar-revisores');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
    btn.disabled = true;
    
    // Mostrar contenedor de documentos
    $('#documentos-generados-container').show();
    $('#documentos-content').html('<div class="text-center p-3"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Generando documentos...</p></div>');
    
    // Realizar petición AJAX
    $.ajax({
        url: '$urlGenerarPdf',
        type: 'POST',
        dataType: 'json',
        data: {
            id: alumnoId,
            tipo_documento: 'revisores',
            _csrf: yii.getCsrfToken()
        },
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            
            // Restaurar botón
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            if (response.success) {
                // Mostrar documentos generados
                mostrarDocumentosGenerados(response);
                mostrarModalDocumentos(response);
            } else {
                $('#documentos-content').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Error: ' + response.error + '</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en AJAX:', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText
            });
            
            // Restaurar botón
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            let errorMsg = 'Error al generar documentos: ';
            
            if (xhr.status === 404) {
                errorMsg += 'Página no encontrada (404). Verifique las rutas.';
            } else if (xhr.status === 500) {
                errorMsg += 'Error interno del servidor (500).';
            } else if (xhr.status === 0) {
                errorMsg += 'No se pudo conectar al servidor.';
            } else {
                errorMsg += xhr.statusText;
            }
            
            $('#documentos-content').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' + errorMsg + '</div>');
        }
    });
}

// Agregar event listener al botón
$(document).ready(function() {
    $('#btn-generar-revisores').click(function() {
        const alumnoId = $(this).data('alumno-id');
        generarDocumentosRevisores(alumnoId);
    });
});

// Función para mostrar los documentos generados en un modal
function mostrarModalDocumentos(response) {
    // Crear contenido del modal
    let modalContent = '<div class="modal fade" id="documentosModal" tabindex="-1" aria-labelledby="documentosModalLabel" aria-hidden="true">';
    modalContent += '<div class="modal-dialog modal-lg">';
    modalContent += '<div class="modal-content">';
    modalContent += '<div class="modal-header bg-success text-white">';
    modalContent += '<h5 class="modal-title" id="documentosModalLabel"><i class="fas fa-file-pdf"></i> Documentos Generados</h5>';
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
    $('#documentosModal').modal('show');
    
    // Remover el modal cuando se cierre
    $('#documentosModal').on('hidden.bs.modal', function () {
        $(this).remove();
    });
}

// Función para mostrar los documentos generados en el contenedor
function mostrarDocumentosGenerados(response) {
    const content = $('#documentos-content');
    
    let html = '<div class="alert alert-success">';
    html += '<i class="fas fa-check-circle"></i> Documentos generados correctamente. ';
    html += '<a href="#" onclick="$(\'#documentosModal\').modal(\'show\'); return false;">Ver documentos</a>';
    html += '</div>';
    
    content.html(html);
}

// JavaScript para manejar la generación de documentos del modal
$(document).ready(function() {
    // Manejar el envío del formulario de generación de documentos
    $('#generar-documento-form').on('submit', function(e) {
        e.preventDefault();
        
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
                    // Cerrar el modal
                    $('#generarDocumentoModal').modal('hide');
                    
                    // Descargar automáticamente el PDF
                    window.open(response.downloadUrl, '_blank');
                    
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Documento generado!',
                        html: 'El documento se ha creado correctamente.<br><br>' +
                              '<div class="text-center">' +
                              '<a href="' + response.downloadUrl + '" class="btn btn-primary m-1">' +
                              '<i class="fas fa-download"></i> Descargar PDF</a> ' +
                              '<a href="' + response.viewUrl + '" target="_blank" class="btn btn-info m-1">' +
                              '<i class="fas fa-eye"></i> Ver documento</a>' +
                              '</div>',
                        showConfirmButton: true,
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error || 'Error al generar el documento'
                    });
                }
            },
            error: function(xhr) {
                btn.html(originalText);
                btn.prop('disabled', false);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor'
                });
            }
        });
    });
    
    $('#tipo-documento').change(function() {
        var tipo = $(this).val();
        var camposDiv = $('#campos-dinamicos');
        camposDiv.empty();
        
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
                
            case 'Estancia':
                camposDiv.html('\
                    <div class="row">\
                        <div class="col-md-6">\
                            <div class="form-group">\
                                <label for="fecha_inicio">Fecha de Inicio</label>\
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>\
                            </div>\
                        </div>\
                        <div class="col-md-6">\
                            <div class="form-group">\
                                <label for="fecha_fin">Fecha de Fin</label>\
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <label for="asesor">Asesor</label>\
                        <input type="text" class="form-control" id="asesor" name="asesor" value="MCIB. Juana Selvan García">\
                    </div>\
                    <div class="form-group">\
                        <label for="proyecto">Proyecto</label>\
                        <input type="text" class="form-control" id="proyecto" name="proyecto" value="Tesis de {$model->programa->nombre}">\
                    </div>\
                ');
                break;
                
            case 'LiberacionTesis':
            case 'Constancia':
                // No requiere campos adicionales
                break;
        }
    });
    
    // Diagnóstico inicial
    console.log('Página cargada correctamente');
    console.log('Función generarDocumentosRevisores definida');
});
JS;

// Registrar el JavaScript en el head para que esté disponible cuando se haga clic en el botón
$this->registerJs($js, \yii\web\View::POS_END);
?>