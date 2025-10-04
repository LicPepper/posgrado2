<?php
// Parámetros esperados:
// - $alumno: modelo Alumno
// - $numeroOficio: string
// - $fecha: string (formato d/m/Y)
// - $tituloTesis: string
// - $lgac: string
// - $revisores: array de nombres de revisores
// - $jefeDivision: string (default: Francisco López Villarreal)
// - $coordinadorMaestria: string
?>
<div style="font-family: 'Times New Roman'; margin: 2cm; line-height: 1.5;">
    <div style="height: 3cm;"></div>
    
    <p style="text-align: center;">
        <strong>TECNOLÓGICO NACIONAL DE MÉXICO.</strong>
    </p>
    
    <p style="text-align: center;">
        <strong>Instituto Tecnológico de Villahermosa</strong>
    </p>
    
    <p style="text-align: center;">
        <strong>División de Estudios de Posgrado e Investigación</strong>
    </p>
    
    <p style="text-align: right;">Villahermosa, Tabasco, <?= $fecha ?></p>
    
    <p style="text-align: center;">
        <strong>ASUNTO: Liberación de trabajo de tesis</strong>
    </p>
    
    <p><strong><?= $jefeDivision ?></strong></p>
    <p><strong>JEFE DE LA DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN</strong></p>
    <p><strong>TECNOLÓGICO NACIONAL DE MÉXICO CAMPUS VILLAHERMOSA</strong></p>
    <p style="text-align: center;"><strong>P R E S E N T E</strong></p>
    
    <p style="text-align: justify;">
        Los que suscriben: <strong><?= implode(', ', $revisores) ?></strong>, 
        sinodales del (la) C. <strong><?= $alumno->nombreCompleto ?></strong> con Número de Control 
        <strong><?= $alumno->matricula ?></strong>, estudiante del programa de posgrado de la 
        <strong><?= $alumno->programa->nombre ?></strong> perteneciente a la LGAC de 
        <strong><?= $lgac ?></strong> después de haber realizado la primera revisión del trabajo profesional, 
        cuyo tema es <strong>"<?= $tituloTesis ?>"</strong>, hacemos constar que se determinó <strong>APROBADO</strong>.
    </p>
    
    <p style="text-align: justify;">
        Esperando que esta información sea de utilidad para continuar con los trámites de titulación correspondientes.
    </p>
    
    <p style="text-align: center;"><strong>A T E N T A M E N T E</strong></p>
    <p style="text-align: center;"><em>Excelencia en Educación Tecnológica®</em></p>
    
    <table style="width: 100%; margin-top: 2cm; text-align: center;">
        <?php foreach ($revisores as $revisor): ?>
        <tr>
            <td>
                <p>__________________________</p>
                <p><strong><?= $revisor ?></strong></p>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <p style="margin-top: 1cm;">
        ccp. Archivo<br>
        <?= $coordinadorMaestria ?> - Coordinador de la <?= $alumno->programa->nombre ?>
    </p>
    
    <p style="margin-top: 0.5cm; font-size: 11px; text-align: center;">
        Carretera Villahermosa - Frontera Km. 3.5 Ciudad Industrial Villahermosa, Tabasco<br>
        Tel. 9933530259 Ext. 230
    </p>
</div>