<?php
use yii\helpers\Html;
/* 
 * Variables disponibles:
 * - $alumno: Datos del alumno
 * - $revisores: Lista de revisores asignados
 * - $tituloTesis: Título de la tesis
 * - $numeroOficio: Número de oficio generado
 */
?>
<div style="font-family: 'Times New Roman'; margin: 2cm; line-height: 1.5;">
    <p style="text-align: right;">Villahermosa, Tabasco, <?= date('d/m/Y') ?></p>
    <p style="text-align: center;"><strong>NO. DE OFICIO: <?= Html::encode($numeroOficio) ?></strong></p>
    <p style="text-align: center;"><strong>ASUNTO: Nombramiento como revisor de tesis</strong></p>

    <p><strong><?= Html::encode($alumno->nombreCompleto) ?></strong></p>
    <p><strong>ESTUDIANTE DE <?= Html::encode($alumno->programa->nombre) ?></strong></p>

    <p style="text-align: center;"><strong>P R E S E N T E</strong></p>

    <p style="text-align: justify;">
        Por este medio le informo que, de acuerdo a la normatividad vigente, se le ha asignado a los siguientes profesores para la revisión de su trabajo de Tesis:
    </p>

    <p><strong>Revisores:</strong></p>
    <ul>
        <?php foreach ($revisores as $revisor): ?>
            <li><strong><?= Html::encode($revisor->nombre) ?></strong></li>
        <?php endforeach; ?>
    </ul>

    <p style="text-align: center;"><strong>A T E N T A M E N T E</strong></p>
    <p style="text-align: center;"><em>Excelencia en Educación Tecnológica®</em></p>

    <div style="margin-top: 2cm; text-align: center;">
        <p><strong>FRANCISCO LÓPEZ VILLARREAL</strong></p>
        <p><strong>JEFE DE LA DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN</strong></p>
    </div>
</div>