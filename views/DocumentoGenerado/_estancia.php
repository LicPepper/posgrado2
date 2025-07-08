<?php
use yii\helpers\Html;

/* @var $alumno app\models\Alumno */
/* @var $fechaInicio string */
/* @var $fechaFin string */
/* @var $asesor string */
/* @var $proyecto string */
/* @var $numeroOficio string */
?>
<div style="font-family: 'Times New Roman'; margin: 2cm; line-height: 1.5;">
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 1cm;">
        <tr>
            <td style="width: 30%; border-bottom: 1px solid black;"><strong>DEPENDENCIA:</strong></td>
            <td style="width: 70%; border-bottom: 1px solid black;">División de Estudios de Posgrado e Investigación</td>
        </tr>
        <tr>
            <td style="width: 30%; border-bottom: 1px solid black;"><strong>N° DE OFICIO:</strong></td>
            <td style="width: 70%; border-bottom: 1px solid black;"><?= Html::encode($numeroOficio) ?></td>
        </tr>
        <tr>
            <td style="width: 30%; border-bottom: 1px solid black;"><strong>ASUNTO:</strong></td>
            <td style="width: 70%; border-bottom: 1px solid black;">Presentación de estudiantes y asesores (trabajo de investigación y estancia)</td>
        </tr>
        <tr>
            <td style="width: 30%;"><strong>FECHA:</strong></td>
            <td style="width: 70%;"><?= Html::encode($fechaInicio) ?></td>
        </tr>
    </table>

    <p><strong>ING. RUBEN REYES SANTANA</strong></p>
    <p><strong>JEFE DE LABORATORIO</strong></p>
    <p style="text-align: center;"><strong>P R E S E N T E</strong></p>

    <p style="text-align: justify;">
        El Instituto Tecnológico Nacional de México campus Villahermosa, tiene a bien presentar a sus finas atenciones al <strong>C. <?= Html::encode($alumno->nombreCompleto) ?></strong>, con número de control <strong><?= Html::encode($alumno->matricula) ?></strong> de la <strong><?= Html::encode($alumno->programa->nombre) ?></strong>, quien desea realizar una estancia en la organización a su digno cargo en el periodo comprendido del <strong><?= Html::encode($fechaInicio) ?> al <?= Html::encode($fechaFin) ?></strong>, para la conclusión de su trabajo de Tesis denominado <strong>"<?= Html::encode($proyecto) ?>"</strong>.
    </p>

    <p style="text-align: justify;">
        Cabe señalar que en todo momento estará asesorado por <strong><?= Html::encode($asesor) ?></strong> docente de esta Institución, quien además estará en contacto con su organización durante el periodo previamente mencionado.
    </p>

    <p style="text-align: justify;">
        Así mismo hacemos presente nuestro sincero agradecimiento por su buena disposición y colaboración para que nuestro estudiante y profesora, tengan la oportunidad de desarrollar este trabajo académico en el contexto empresarial, donde pueda aplicar el conocimiento y el trabajo en el campo de acción.
    </p>

    <p style="text-align: center;"><strong>A T E N T A M E N T E</strong></p>
    <p style="text-align: center;"><em>Excelencia en Educación Tecnológica®</em></p>

    <div style="margin-top: 2cm; text-align: center;">
        <p><strong>FRANCISCO LÓPEZ VILLARREAL</strong></p>
        <p><strong>JEFE DE LA DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN</strong></p>
    </div>
</div>