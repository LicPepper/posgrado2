<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Requisito $model */

$this->title = Yii::t('app', 'Create Requisito');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Requisitos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisito-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
