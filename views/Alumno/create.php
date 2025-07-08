<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Alumno $model */

$this->title = Yii::t('app', 'Create Alumno');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alumnos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alumno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
