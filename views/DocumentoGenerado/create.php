<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\TuModeloDeBusqueda */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = 'Historial de Documentos Generados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documento-generado-historial">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="table-responsive">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                // Aquí defines las columnas que quieres mostrar
                'id',
                'nombre_documento',
                'fecha_creacion:datetime',
                'usuario_creacion',
                // ...
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>