<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Revisores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Obtener usuario actual y sus permisos
$user = Yii::$app->user->identity;
$puedeEditar = $user && $user->puede('editar');
$puedeEliminar = $user && $user->puede('eliminar');

?>

<div class="revisor-view">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Detalles del Revisor</h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-edit"></i> Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-light btn-sm']) ?>
                <?= Html::a('<i class="fas fa-list"></i> Volver', ['index'], ['class' => 'btn btn-light btn-sm']) ?>
            </div>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'nombre',
                    'cargo',
                    [
                        'attribute' => 'activo',
                        'value' => $model->activo ? 
                            '<span class="badge bg-success">Activo</span>' : 
                            '<span class="badge bg-secondary">Inactivo</span>',
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>