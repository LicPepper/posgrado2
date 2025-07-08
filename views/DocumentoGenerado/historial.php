<?php
use yii\helpers\Html;
use yii\grid\GridView;

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
            <h1 class="card-title">
                <i class="fas fa-history"></i> <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tipo de Documento</th>
                            <th>Fecha de Generación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($documentos as $documento): ?>
                        <tr>
                            <td><?= Html::encode($documento->plantilla->nombre ?? 'N/A') ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($documento->fecha_generacion) ?></td>
                            <td><?= $documento->getEstadoLabel() ?></td>
                            <td>
                                <?= Html::a(
                                    '<i class="fas fa-download"></i> Descargar', 
                                    ['download', 'id' => $documento->id], 
                                    ['class' => 'btn btn-sm btn-success']
                                ) ?>
                                <?= Html::a(
                                    '<i class="fas fa-eye"></i> Ver', 
                                    ['view', 'id' => $documento->id], 
                                    ['class' => 'btn btn-sm btn-info']
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <?php if (empty($documentos)): ?>
                    <div class="alert alert-info">
                        No se han generado documentos para este alumno.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>