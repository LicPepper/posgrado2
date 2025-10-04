<?php
use yii\helpers\Html;

// Formatear fecha y hora
$fechaFormateada = date('d/m/Y', strtotime($fechaExamen));
$horaFormateada = date('H:i', strtotime($horaExamen));
?>

<div class="texto-documento">
    <!-- Espacio superior de 4cm -->
    <div style="height: 3cm;"></div>

    <p style="text-align: right;">Villahermosa, Tabasco, <?= date('d/m/Y') ?></p>
    <p style="text-align: center;"><strong>NO. DE OFICIO: <?= Html::encode($numeroOficio) ?></strong></p>
    <p style="text-align: center;"><strong>ASUNTO: Autorización de examen</strong></p>

    <p><strong>EZEQUIEL NOTARIO PRIEGO</strong></p>
    <p><strong>JEFE DEL DEPARTAMENTO DE SERVICIOS ESCOLARES</strong></p>
    <p style="text-align: center;"><strong>P R E S E N T E</strong></p>

    <p style="text-align: justify;">
        Por medio de la presente, me permito solicitar se autorice la sustentación del acto de Recepción del C. <strong><?= Html::encode($alumno->nombreCompleto) ?></strong>,
        con número de Control <strong><?= Html::encode($alumno->matricula) ?></strong> para la obtención del grado de 
        <strong><?= Html::encode($alumno->programa->nombre) ?></strong>, mediante la opción de Tesis.
    </p>

    <p style="text-align: justify;">
        Dicho acto se realizará el <strong><?= Html::encode($fechaFormateada) ?></strong> a las <strong><?= Html::encode($horaFormateada) ?></strong> horas, 
        de manera presencial en la sala de titulación de posgrado, en virtud de haber cubierto los requisitos 
        conforme al reglamento de titulación.
    </p>

    <p style="text-align: justify;">
        Sin más por el momento, me despido agradeciendo de antemano la atención a la presente.
    </p>

    <p style="text-align: center;"><strong>A T E N T A M E N T E</strong></p>
    <p style="text-align: center;"><em>Excelencia en Educación Tecnológica®</em></p>
    <p style="text-align: center;"><em>Tierra, Tiempo, Trabajo y Tecnología®</em></p>

    <div style="margin-top: 2cm; text-align: center;">
        <p><strong>FRANCISCO LÓPEZ VILLARREAL</strong></p>
        <p><strong>JEFE DE LA DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN</strong></p>
    </div>

    <div style="margin-top: 1cm;">
        <p><strong>ccp.</strong> Archivo</p>
        <p>David Antonio García Reyes – Coordinador de la Maestría</p>
        <p>FLV/dagr</p>
    </div>
</div>