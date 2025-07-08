<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AvanceAlumno $model */

$this->title = Yii::t('app', 'Create Avance Alumno');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Avance Alumnos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="AvanceAlumno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
