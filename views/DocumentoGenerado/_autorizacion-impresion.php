<?php
// Parámetros esperados:
// - $alumno: modelo Alumno
// - $numeroOficio: string
// - $fecha: string (formato d/m/Y)
// - $tituloTesis: string
// - $revisores: array de nombres de revisores
// - $jefeDivision: string (default: Francisco López Villarreal)
?>
<div style="font-family: 'Times New Roman'; margin: 2cm; line-height: 1.5;">
 <div style="height: 3cm;"></div>

    <p style="text-align: center;">
        <strong>Instituto Tecnológico de Villahermosa</strong>
    </p>
    
    <p style="text-align: center;">
        <strong>División de Estudios de Posgrado e Investigación</strong>
    </p>
    
    <p style="text-align: right;">Villahermosa, Tabasco, <?= $fecha ?></p>
    
    <p style="text-align: center;">
        <strong>Oficio No. <?= $numeroOficio ?></strong>
    </p>
    
    <p style="text-align: center;">
        <strong>ASUNTO: Autorización de impresión</strong>
    </p>
    
    <p><strong><?= $alumno->nombreCompleto ?></strong></p>
    <p><strong>ESTUDIANTE DE LA <?= strtoupper($alumno->programa->nombre) ?></strong></p>
    <p style="text-align: center;"><strong>P R E S E N T E</strong></p>
    
    <p style="text-align: justify;">
        De acuerdo al fallo emitido por la comisión revisora integrada por 
        <strong><?= implode(', ', $revisores) ?></strong>, considerando que cubre los requisitos del 
        Reglamento de Titulación en vigor, se da a usted la autorización para que proceda a imprimir su 
        trabajo profesional titulado:
    </p>
    
    <p style="text-align: center; font-style: italic;">
        "<?= $tituloTesis ?>"
    </p>
    
    <p style="text-align: justify;">
        Hago de su conocimiento lo anterior para los efectos y fines correspondientes.
    </p>
    
    <p style="text-align: center;"><strong>A T E N T A M E N T E</strong></p>
    <p style="text-align: center;"><em>Excelencia en Educación Tecnológica®</em></p>
    
    <div style="margin-top: 2cm; text-align: center;">
        <p>__________________________</p>
        <p><strong><?= $jefeDivision ?></strong></p>
        <p><strong>JEFE DE LA DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN</strong></p>
    </div>
    
    <p style="margin-top: 1cm;">
        ccp. Archivo
    </p>
    
    <p style="margin-top: 0.5cm; font-size: 11px; text-align: center;">
        Carretera Villahermosa - Frontera Km. 3.5 Ciudad Industrial Villahermosa, Tabasco<br>
        Tel. 9933530259 Ext. 230
    </p>
</div>