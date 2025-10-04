<?php
use yii\helpers\Html;

// Formatear fecha y hora
$fechaFormateada = date('d/m/Y', strtotime($fechaActo));
$horaFormateada = date('H:i', strtotime($horaActo));
?>

<div class="texto-documento">
    <!-- Espacio superior de 4cm -->
     <div style="height: 3cm;"></div>

    <p style="text-align: right;">Villahermosa, Tabasco, <?= date('d/m/Y') ?></p>
    <p style="text-align: center;"><strong>NO. DE OFICIO: <?= Html::encode($numeroOficio) ?></strong></p>
    <p style="text-align: center;"><strong>ASUNTO: Autorización del acto de recepción de grado</strong></p>

    <p><strong><?= Html::encode($revisor->nombre) ?></strong></p>
    <p><strong>CATEDRÁTICO DEL INSTITUTO TECNOLÓGICO DE VILLAHERMOSA</strong></p>
    <p style="text-align: center;"><strong>P R E S E N T E</strong></p>

    <p style="text-align: justify;">
        Por medio de la presente, me permito informarle que se autorizó realizar el acto de recepción profesional para la
        obtención del grado de <strong><?= Html::encode($alumno->programa->nombre) ?></strong> al (a la) C. 
        <strong><?= Html::encode($alumno->nombreCompleto) ?></strong>, con Número de Control <strong><?= Html::encode($alumno->matricula) ?></strong>, 
        por la opción de tesis, por lo que me permito citarlo a la realización del acto recepcional en su calidad de 
        <strong><?= Html::encode($tipoRevisor) ?></strong>, del H. Jurado, en el siguiente horario:
    </p>

    <div style="text-align: center; margin: 1cm 0;">
        <p><strong>FECHA: <?= Html::encode($fechaFormateada) ?></strong></p>
        <p><strong>HORA: <?= Html::encode($horaFormateada) ?> HORAS</strong></p>
        <p><strong>LUGAR: SALA DE TITULACIÓN</strong></p>
    </div>

    <p style="text-align: justify;">
        El otorgamiento de grado será responsabilidad de los miembros del H. Jurado, del cual usted forma parte; 
        de igual forma, se deberá dar cumplimiento a los requisitos establecidos por el manual de procedimientos 
        para la obtención de título y cédula de grado en vigor.
    </p>

    <p style="text-align: justify;">
        Seguro de su puntual asistencia, quedo de usted.
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
        <p>FLV/dang</p>
    </div>
</div>