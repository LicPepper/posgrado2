<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Mi Perfil', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="usuario-view">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">
                <i class="fas fa-user-circle"></i> Información del Perfil
            </h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-edit"></i> Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-light btn-sm']) ?>
                <?= Html::a('<i class="fas fa-home"></i> Inicio', ['site/index'], ['class' => 'btn btn-light btn-sm']) ?>
            </div>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'id',
                        'label' => 'ID de Usuario',
                    ],
                    [
                        'attribute' => 'username',
                        'label' => 'Nombre de usuario',
                    ],
                    [
                        'attribute' => 'nombre',
                        'label' => 'Nombre completo',
                    ],
                    [
                        'attribute' => 'email',
                        'label' => 'Correo electrónico',
                        'format' => 'email',
                    ],
                    [
                        'attribute' => 'rol',
                        'value' => function($model) {
                            return $model->displayRol();
                        },
                        'label' => 'Rol',
                    ],
                    [
                        'attribute' => 'activo',
                        'value' => function($model) {
                            return $model->activo ? 
                                '<span class="badge bg-success">Activo</span>' : 
                                '<span class="badge bg-secondary">Inactivo</span>';
                        },
                        'format' => 'raw',
                        'label' => 'Estado',
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="mt-3">
        <?= Html::a('<i class="fas fa-cog"></i> Editar Configuración', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fas fa-home"></i> Volver al Inicio', ['site/index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>

<style>
.usuario-view {
    padding: 20px;
}
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
</style>