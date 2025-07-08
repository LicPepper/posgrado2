<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $alumno app\models\Alumno */
/* @var $fecha string */
/* @var $numeroOficio string */
/* @var $articulo string */
?>
<div style="font-family: 'Times New Roman'; margin: 2cm; line-height: 1.5;">
    <p style="text-align: right;">Villahermosa, Tabasco, <?= Html::encode($fecha) ?></p>

    <p style="text-align: center;"><strong>NO. DE OFICIO:</strong> <?= Html::encode($numeroOficio) ?></p>

    <p style="text-align: center;"><strong>ASUNTO:</strong> Constancia de Dictamen</p>

    <p><strong>A QUIEN CORRESPONDA:</strong></p>

    <p style="text-align: justify;">
        El que suscribe, jefe de la División de Estudios de Posgrado e Investigación, HACE CONSTAR, que el <strong>C. <?= Html::encode($alumno->nombreCompleto) ?></strong> con número de control <strong><?= Html::encode($alumno->matricula) ?></strong>, alumno de la <strong><?= Html::encode($alumno->programa->nombre) ?></strong>, presentó la constancia del ARTÍCULO <strong>"<?= Html::encode($articulo) ?>"</strong>, que le acredita el idioma inglés como requisito en los lineamientos de Posgrado.
    </p>

    <p style="text-align: justify;">
        Por lo anterior, se considera la <strong>ACREDITACIÓN</strong> del idioma inglés, para efectos de titulación de estudios de posgrado.
    </p>

    <p style="text-align: justify;">
        Se extiende la presente en la Ciudad de Villahermosa, Tabasco, a los <?= date('d') ?> días del mes de <?= date('F') ?> del <?= date('Y') ?>.
    </p>

    <div style="margin-top: 2cm;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; text-align: center;">
                    <p>__________________________</p>
                    <p><strong>Francisco López Villarreal</strong></p>
                    <p>Jefe de la División de Estudios de</p>
                    <p>Posgrado e Investigación</p>
                </td>
                <td style="width: 50%; text-align: center;">
                    <p>__________________________</p>
                    <p><strong>Vo.Bo.</strong></p>
                    <p><strong>Juan Manuel Urrieta Saltijeral</strong></p>
                    <p>Presidente del Consejo de Posgrado</p>
                    <p>de la Maestría en Ingeniería</p>
                </td>
            </tr>
        </table>
    </div>
</div>