<?php
use yii\helpers\Html;
?>
<div style="font-family: 'Times New Roman', Times, serif; font-size: 11.5pt; line-height: 1.3;">

    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td width="50%" style="text-align: left;">
                <p>Villahermosa, Tabasco, <?= date('d/m/Y') ?></p>
            </td>
            <td width="50%" style="text-align: right;">
                <p><strong>Oficio No. <?= Html::encode($numeroOficio) ?></strong></p>
                <p><strong>ASUNTO: Nombramiento como revisor de tesis</strong></p>
            </td>
        </tr>
    </table>

    <div style="margin-top: 15px; font-weight: bold;">
        <p><?= strtoupper(Html::encode($revisor->nombre)) ?></p>
        <p>CATEDRÁTICO DEL INSTITUTO TECNOLÓGICO DE VILLAHERMOSA</p>
    </div>
    
    <p style="margin: 15px 0; font-weight: bold;">P R E S E N T E</p>
    
    <p style="text-align: justify; margin-bottom: 15px;">
        A través de la presente le informo que usted ha sido asignado por parte del Consejo Académico de Posgrado como <strong>REVISOR(A) DE TESIS</strong> del alumno(a) <strong><?= strtoupper(Html::encode($alumno->nombreCompleto)) ?></strong>, con Número de Control <strong><?= Html::encode($alumno->matricula) ?></strong>, de la <strong><?= Html::encode($alumno->programa->nombre) ?></strong> perteneciente a la LGAC de <strong>Calidad y Sustentabilidad en la Organizaciones</strong> cuyo título de tesis es <strong>"<?= strtoupper(Html::encode($tituloTesis)) ?>"</strong>.
    </p>
    
    <p style="text-align: justify; margin-bottom: 20px;">
        Me despido de usted agradeciendo las atenciones que brinde al alumno antes mencionado en la revisión de su trabajo para que continúe con el proceso respectivo.
    </p>
    
    <div style="text-align: center; margin-top: 25px;">
        <p><strong>A T E N T A M E N T E</strong></p>
    </div>
    
    <div style="text-align: center; font-style: italic; line-height: 1.2;">
        <p style="margin: 0;"><em>Excelencia en Educación Tecnológica®</em></p>
        <p style="margin: 0;"><em>Tierra, Tiempo, Trabajo y Tecnología®</em></p>
    </div>
    
    <div style="margin-top: 35px; text-align: center; font-weight: bold;">
        <p>FRANCISCO LÓPEZ VILLARREAL</p>
        <p>JEFE DE LA DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN</p>
    </div>
    
    <div style="margin-top: 30px; font-size: 10pt; line-height: 1.2;">
        <p>ccp. Archivo</p>
        <p>David Antonio García Reyes – Coordinador de la Maestría</p>
        <p>FLV/dang</p>
    </div>

</div>