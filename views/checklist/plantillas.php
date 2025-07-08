<?php
use yii\helpers\Html;

/** @var $alumno app\models\Alumno */
/** @var $checklist app\models\Checklist */

?>

<h2>ITVH - Área de Posgrado</h2>
<hr>
<p><strong>Nombre del alumno:</strong> <?= Html::encode($alumno->nombre) ?></p>
<p><strong>Matrícula:</strong> <?= Html::encode($alumno->matricula) ?></p>
<p><strong>Programa:</strong> <?= Html::encode($alumno->programa) ?></p>
<p><strong>Email:</strong> <?= Html::encode($alumno->email) ?></p>
<p><strong>Estado de checklist:</strong> <?= Html::encode($checklist->estado) ?></p>
<p><strong>Fecha de creación:</strong> <?= Yii::$app->formatter->asDate($checklist->fecha_creacion) ?></p>
