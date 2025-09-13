<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Programa $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Programas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Obtener usuario actual y sus permisos
$user = Yii::$app->user->identity;
$puedeEditar = $user && $user->puede('editar');

\yii\web\YiiAsset::register($this);
?>
<div class="programa-view">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Detalles del Programa</h3>
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
                    [
                        'attribute' => 'nivel',
                        'value' => function($model) {
                            return $model->displayNivel();
                        }
                    ],
                    [
                        'attribute' => 'descripcion',
                        'format' => 'ntext',
                        'value' => function($model) {
                            return $model->descripcion ? $model->descripcion : 'Sin descripción';
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>