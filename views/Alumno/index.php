<?php

use app\models\Alumno;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Listado de Alumnos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="AlumnoIndex">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => SerialColumn::class],
            
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'matricula',
            [
                'attribute' => 'programa_id',
                'value' => function($model) {
                    return $model->programa->nombre ?? 'N/A';
                }
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view}',
                'urlCreator' => function ($action, Alumno $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped'],
    ]); ?>

</div>