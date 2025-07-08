<?php
use yii\helpers\Html;
use yii\helpers\Url; // También es buena práctica importar Url si lo usas
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Constancia de Alumno</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; }
        .content { margin: 0 auto; width: 90%; }
        .footer { text-align: center; margin-top: 50px; font-size: 10pt; }
        .fecha { text-align: right; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h2>INSTITUTO TECNOLÓGICO DE VILLAHERMOSA</h2>
        <h3>CONSTANCIA DE ALUMNO</h3>
    </div>
    
    <div class="content">
        <p>Por medio de la presente se hace constar que:</p>
        
        <p><strong>Nombre:</strong> <?= Html::encode($model->nombreCompleto) ?></p>
        <p><strong>Matrícula:</strong> <?= Html::encode($model->matricula) ?></p>
        <p><strong>Programa:</strong> <?= Html::encode($model->programa->nombre ?? 'N/A') ?></p>
        <p><strong>Email:</strong> <?= Html::encode($model->email) ?></p>
        
        <h4>Requisitos Completados:</h4>
        <table>
            <thead>
                <tr>
                    <th>Requisito</th>
                    <th>Fecha de Completado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requisitos as $requisito): ?>
                    <?php if ($requisito->completado): ?>
                    <tr>
                        <td><?= Html::encode($requisito->requisito->nombre) ?></td>
                        <td><?= Yii::$app->formatter->asDate($requisito->fecha_completado) ?></td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <p class="fecha">Villahermosa, Tabasco a <?= date('d') ?> de <?= date('F') ?> de <?= date('Y') ?></p>
        
        <div class="firma">
            <p>_________________________</p>
            <p>Nombre y Firma</p>
            <p>Coordinador de Posgrado</p>
        </div>
    </div>
    
    <div class="footer">
        <p>Documento generado automáticamente el <?= date('d/m/Y H:i:s') ?></p>
    </div>
</body>
</html>