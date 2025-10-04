<?php
// Parámetros esperados:
// - $alumno: modelo Alumno
// - $numeroOficio: string
// - $fecha: string (formato d/m/Y)
// - $tituloTesis: string
// - $lgac: string
// - $porcentajeCoincidencia: string
// - $jefeDivision: string (default: Francisco López Villarreal)
// - $coordinadorMaestria: string
?>
<div style="font-family: 'Times New Roman'; margin: 2cm; line-height: 1.5;">
     <div style="height: 2cm;"></div>
    <p style="text-align: right;">Villahermosa, Tabasco, <?= $fecha ?></p>
    
    <p style="text-align: center;">
        <strong>NO. DE OFICIO:</strong> <?= $numeroOficio ?>
    </p>
    
    <p style="text-align: center;">
        <strong>ASUNTO:</strong> Liberación de trabajo de tesis
    </p>
    
    <p><strong><?= $jefeDivision ?></strong></p>
    <p><strong>JEFE DE LA DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN</strong></p>
    <p><strong>TECNOLÓGICO NACIONAL DE MÉXICO CAMPUS VILLAHERMOSA</strong></p>
    <p style="text-align: center;"><strong>P R E S E N T E</strong></p>
    
    <p style="text-align: justify;">
        Por medio del presente tengo a bien informarle que el (la) C. <strong><?= $alumno->nombreCompleto ?></strong> 
        estudiante de la <strong><?= $alumno->programa->nombre ?></strong> perteneciente a la LGAC de 
        <strong><?= $lgac ?></strong>, con número de control <strong><?= $alumno->matricula ?></strong> 
        ha concluido satisfactoriamente la realización del Proyecto de Tesis denominado: 
        <strong>"<?= $tituloTesis ?>"</strong>, verificando su originalidad mediante el software Turnitin, 
        se adjunta la evidencia del reporte presentando una coincidencia general del <strong><?= $porcentajeCoincidencia ?>%</strong>, 
        por lo cual en calidad de Director de Tesis, se emite este oficio de liberación.
    </p>
    
    <p style="text-align: justify;">
        Lo anterior para que el alumno pueda dar continuidad a los trámites correspondientes al proceso de obtención de grado.
    </p>
    
    <p style="text-align: justify;">
        Sin más que agregar al presente, reciba un cordial saludo.
    </p>
    
    <p style="text-align: center;"><strong>A T E N T A M E N T E</strong></p>
    <p style="text-align: center;"><em>Excelencia en Educación Tecnológica®</em></p>
    
    <table style="width: 100%; margin-top: 2cm;">
        <tr>
            <td style="width: 50%; text-align: center;">
                <p>__________________________</p>
                <p><strong>DIRECTOR DE TESIS</strong></p>
            </td>
            <td style="width: 50%; text-align: center;">
                <p>__________________________</p>
                <p><strong><?= $jefeDivision ?></strong></p>
                <p>Jefe de la División de Estudios de</p>
                <p>Posgrado e Investigación</p>
            </td>
        </tr>
    </table>
    
    <p style="margin-top: 1cm;">
        ccp. <?= $coordinadorMaestria ?> - Coordinador de la <?= $alumno->programa->nombre ?>
    </p>
</div>