<?php

use app\models\AvanceAlumno;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AvanceAlumnoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Avance Alumnos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="AvanceAlumno-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Avance Alumno'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'alumno_id',
            'requisito_id',
            'completado',
            'fecha_completado',
            //'evidencia',
            //'comentarios:ntext',
            //'validado_por',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, AvanceAlumno $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
