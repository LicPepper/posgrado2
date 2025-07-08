<?php
use yii\helpers\Html;
?>
<div style="font-family: Arial; margin: 2cm;">
    <div style="text-align: center; margin-bottom: 1.5cm;">
        <h2>INSTITUTO TECNOLÓGICO DE VILLAHERMOSA</h2>
        <h3>CONSTANCIA</h3>
    </div>
    
    <p style="text-align: justify;">
        Por medio de la presente se hace constar que el(la) C. <?= Html::encode($alumno->nombreCompleto) ?>, 
        con matrícula <?= Html::encode($alumno->matricula) ?>, está regularmente inscrito(a) en el programa de 
        <?= Html::encode($alumno->programa->nombre) ?> de esta institución.
    </p>
    
    <p style="text-align: justify;">
        Se extiende la presente a petición del interesado(a) para los fines que juzgue convenientes.
    </p>
    
    <div style="margin-top: 3cm; text-align: right;">
        <p>Villahermosa, Tabasco a <?= date('d') ?> de <?= date('F') ?> de <?= date('Y') ?></p>
        <p>_________________________</p>
        <p>Nombre y Firma</p>
        <p>Coordinador de Posgrado</p>
    </div>
</div>