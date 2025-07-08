<?php
use yii\helpers\Html;
?>
<div style="font-family: 'Times New Roman'; margin: 2cm; line-height: 1.5;">
    <p style="text-align: right;">Villahermosa, Tabasco, <?= date('d/m/Y') ?></p>

    <p style="text-align: center;"><strong>NO. DE OFICIO:</strong> <?= $this->context->generarNumeroOficio('Liberación Tesis') ?></p>

    <p style="text-align: center;"><strong>ASUNTO:</strong> Constancia de Dictamen</p>

    <p><strong>FRANCISCO LÓPEZ VILLARREAL</strong></p>
    <p><strong>JEFE DE LA DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN</strong></p>
    <p><strong>TECNOLÓGICO NACIONAL DE MÉXICO CAMPUS VILLAHERMOSA</strong></p>

    <p style="text-align: center;"><strong>P R E S E N T E</strong></p>

    <p style="text-align: justify;">Los que suscriben: <strong>MIPA. MARÍA BERZABÉ VÁZQUEZ GONZÁLEZ, DR. MARIO JOSÉ ROMELLÓN CERINO, MIPA. JOSÉ REYES OSORIO, DR JUAN MANUEL URRIETA SALTIJERAL</strong>, sinodales del <strong>C. <?= Html::encode($alumno->nombreCompleto) ?></strong> con Número de Control <strong><?= Html::encode($alumno->matricula) ?></strong>, estudiante del programa de posgrado de la <strong><?= Html::encode($alumno->programa->nombre ?? 'Maestría en Ingeniería') ?></strong>, después de haber realizado la primera revisión del trabajo profesional, cuyo tema es <strong>"<?= Html::encode($alumno->titulo_tesis ?? 'Título no especificado') ?>"</strong>, hacemos constar que se determinó <strong>APROBADO.</strong></p>

    <p style="text-align: justify;">Esperando que esta información sea de utilidad para continuar con los trámites de titulación correspondientes.</p>

    <p style="text-align: center;"><strong>A T E N T A M E N T E</strong></p>

    <p style="text-align: center;"><em>Excelencia en Educación Tecnológica®</em></p>

    <table style="width: 100%; margin-top: 2cm; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; border: none; text-align: center;">
                <p>__________________________</p>
                <p><strong>MIPA. MARÍA BERZABÉ VÁZQUEZ GONZÁLEZ</strong></p>
            </td>
            <td style="width: 50%; border: none; text-align: center;">
                <p>__________________________</p>
                <p><strong>DR. MARIO JOSÉ ROMELLÓN CERINO</strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; border: none; text-align: center; padding-top: 1cm;">
                <p>__________________________</p>
                <p><strong>MIPA. JOSÉ REYES OSORIO</strong></p>
            </td>
            <td style="width: 50%; border: none; text-align: center; padding-top: 1cm;">
                <p>__________________________</p>
                <p><strong>DR. JUAN MANUEL URRIETA SALTIJERAL</strong></p>
            </td>
        </tr>
    </table>
</div>