<?php
use yii\helpers\Html;

// Parámetros esperados:
// - $alumno: modelo Alumno
// - $numeroOficio: string
// - $fecha: string (formato d/m/Y)
// - $tituloTesis: string
// - $presidente: string (nombre del presidente del jurado)
// - $secretario: string (nombre del secretario del jurado)  
// - $vocal: string (nombre del vocal del jurado)
// - $vocalSuplente: string (opcional, nombre del vocal suplente)
// - $horaExamen: string (formato H:i)
// - $fechaExamen: string (fecha del examen)

// Formatear fecha y hora
$fechaFormateada = date('d/m/Y', strtotime($fechaExamen));
$horaFormateada = date('H:i', strtotime($horaExamen));
$fechaActual = date('d/m/Y');
?>

<div style="font-family: 'Geomanist', 'Times New Roman', sans-serif; line-height: 1.5; margin: 0; padding: 0;">
    <!-- Página 1: Protesta de Ley -->
    <div style="page-break-after: always; padding: 2cm;">
        <!-- Espacio adicional de 2 cm en la parte superior -->
        <div style="height: 2cm;"></div>
        
        <div style="text-align: center;">
            <p style="font-size: 11px; margin: 0; font-weight: bold;">TECNM / INSTITUTO TECNOLÓGICO DE VILLAHERMOSA</p>
            <br><br>
            <p style="font-size: 11px; margin: 0; font-weight: bold;">DIVISIÓN DE ESTUDIOS DE POSGRADO E INVESTIGACIÓN</p>
            <br><br><br>
            <p style="font-size: 16px; font-weight: bold; text-decoration: underline; margin: 0;">PROTESTA DE LEY</p>
            <br><br><br>
            <p style="font-size: 12px; margin: 0; font-weight: bold;">C. <?= Html::encode($alumno->nombreCompleto) ?></p>
            <br><br><br>
        </div>

        <div style="text-align: justify; font-size: 11px; line-height: 1.6;">
            <p style="margin: 0; text-align: center;">
                ¿Protesta Usted ejercer la profesión con absoluto respeto a las normas establecidas por la Constitución Política de los Estados Unidos Mexicanos y la Ley Reglamentaria del Artículo 5° Constitucional, así como su Reglamento respectivo con la responsabilidad y decisión que ella requiere, con respeto, dignidad y la ética profesional que de usted espera el pueblo de México y el Instituto Tecnológico de Villahermosa que hoy le otorga el grado de
            </p>
            <br><br>
            <p style="text-align: center; font-weight: bold; margin: 0;">
                <?= Html::encode($alumno->programa->nombre) ?>
            </p>
            <br><br><br>
            <p style="text-align: center; font-weight: bold; margin: 0;">
                ¡Sí protesto!
            </p>
            <br><br><br>
            <p style="text-align: center; margin: 0;">
                Que sea su propia conciencia y sociedad a la que va a servir quienes vigilen el cumplimiento de esta protesta.
            </p>
            <br><br><br>
        </div>

        <div style="text-align: center; margin-top: 1cm;">
            <p style="font-size: 11px; margin: 0;">Villahermosa, Tabasco, a <?= $fechaFormateada ?></p>
        </div>
    </div>

    <!-- Página 2: Protocolo de inicio -->
    <div style="page-break-after: always; padding: 2cm;">
        <!-- Espacio adicional de 2 cm en la parte superior -->
        <div style="height: 2cm;"></div>

        <div style="text-align: center; margin: 0.3cm 0;">
            <p style="font-size: 11px; margin: 2px 0;"><strong>TECNM / INSTITUTO TECNOLÓGICO DE VILLAHERMOSA</strong></p>
        </div>

        <div style="text-align: center; margin: 0.5cm 0;">
            <p style="font-size: 12px; font-weight: bold; text-decoration: underline; margin: 2px 0;">
                PROTOCOLO QUE DEBE SEGUIRSE PARA INICIAR<br>
                UN EXAMEN PROFESIONAL
            </p>
        </div>

        <div style="text-align: justify; margin: 0.5cm 0; font-size: 11px;">
            <p style="font-weight: bold; margin: 5px 0;">PRESIDENTE: SE SOLICITA A TODAS LAS PERSONAS PRESENTES, A PONERSE DE PIE.</p>
            
            <p style="margin: 5px 0; text-align: justify;">
                Con la autoridad que nos concede el reglamento de la Dirección General de Educación Superior, y de acuerdo con lo prescrito por la Secretaría de Educación Pública, celebramos el examen de obtención de grado de <strong><?= Html::encode($alumno->programa->nombre) ?> del (la) C. <?= Html::encode($alumno->nombreCompleto) ?> con número de control <?= Html::encode($alumno->matricula) ?>, siendo las <?= $horaFormateada ?> horas del día <?= $fechaFormateada ?>.
            </p>
            
            <p style="margin: 5px 0; text-align: justify;">
                Agradecemos a la concurrencia guardar silencio.
            </p>
            
            <p style="text-align: center; font-weight: bold; margin: 10px 0;">MUCHAS GRACIAS.</p>
        </div>
    </div>

    <!-- Página 3: Recepción de pago -->
    <div style="page-break-after: always; padding: 2cm;">
        <!-- Espacio adicional de 2 cm en la parte superior -->
        <div style="height: 2cm;"></div>

        <div style="margin: 0.5cm 0;">
            <p style="font-size: 11px; text-align: justify; margin: 5px 0;">
                Recibimos copia del recibo de pago de derecho a Examen para obtención de Grado de Maestría en:
            </p>
            
            <p style="text-align: center; font-weight: bold; margin: 10px 0;">
                <?= Html::encode($alumno->programa->nombre) ?>
            </p>
            
            <p style="text-align: justify; margin: 5px 0;">
                Del (la) C. <strong><?= Html::encode($alumno->nombreCompleto) ?></strong> con número de control <strong><?= Html::encode($alumno->matricula) ?></strong>
            </p>
            
            <table style="width: 100%; margin: 10px 0;">
                <tr>
                    <td style="width: 30%;">Folio: ______</td>
                    <td>del libro de: ______</td>
                </tr>
            </table>
            
            <table style="width: 100%; margin: 15px 0; font-size: 11px;">
                <tr>
                    <td style="width: 40%;"><strong>Presidente:</strong></td>
                    <td><?= Html::encode($presidente) ?></td>
                </tr>
                <tr>
                    <td><strong>Secretario:</strong></td>
                    <td><?= Html::encode($secretario) ?></td>
                </tr>
                <tr>
                    <td><strong>Vocal:</strong></td>
                    <td><?= Html::encode($vocal) ?></td>
                </tr>
                <tr>
                    <td><strong>Vocal Suplente:</strong></td>
                    <td><?= !empty($vocalSuplente) ? Html::encode($vocalSuplente) : '__________________________' ?></td>
                </tr>
            </table>
        </div>

        <div style="text-align: center; margin-top: 0.5cm;">
            <p style="font-size: 11px; margin: 0;">Villahermosa, Tabasco, a <?= $fechaFormateada ?></p>
        </div>

    <!-- Página 4: Integración del jurado -->
    <div style="page-break-after: always; padding: 2cm;">
        <!-- Espacio adicional de 2 cm en la parte superior -->
        <div style="height: 2cm;"></div>
        
        <div style="margin: 0.5cm 0;">
            <p style="font-size: 11px; text-align: justify; margin: 5px 0;">
                Villahermosa, Tabasco, México, siendo las <?= $horaFormateada ?> horas del día <?= $fechaFormateada ?>, se celebra el examen para obtención de grado, del (la) C. <strong><?= Html::encode($alumno->nombreCompleto) ?></strong> con número de control <strong><?= Html::encode($alumno->matricula) ?></strong>, estudiante de la <strong><?= strtoupper($alumno->programa->nombre) ?></strong>, el jurado estará integrado de la siguiente manera:
            </p>
            
            <table style="width: 100%; margin: 15px 0; font-size: 11px;">
                <tr>
                    <td style="width: 30%;"><strong>PRESIDENTE:</strong></td>
                    <td><?= Html::encode($presidente) ?></td>
                </tr>
                <tr>
                    <td><strong>SECRETARIO:</strong></td>
                    <td><?= Html::encode($secretario) ?></td>
                </tr>
                <tr>
                    <td><strong>VOCAL:</strong></td>
                    <td><?= Html::encode($vocal) ?></td>
                </tr>
                <tr>
                    <td><strong>VOCAL SUPLENTE:</strong></td>
                    <td><?= !empty($vocalSuplente) ? Html::encode($vocalSuplente) : '__________________________' ?></td>
                </tr>
            </table>
            
            <p style="font-weight: bold; margin: 10px 0;">Observaciones:</p>
            <p style="border-bottom: 1px solid black; height: 30px; margin: 3px 0;"></p>
            <p style="border-bottom: 1px solid black; height: 30px; margin: 3px 0;"></p>
        </div>
    </div>

    <!-- Página 5: Juramento de ética -->
    <div style="page-break-after: always; padding: 2cm;">
        <!-- Espacio adicional de 2 cm en la parte superior -->
        <div style="height: 2cm;"></div>
        
        <div style="text-align: center; margin-bottom: 0.5cm;">
            <p style="font-size: 12px; font-weight: bold; margin: 2px 0;">Instituto Tecnológico de Villahermosa</p>
            <p style="font-size: 11px; margin: 2px 0;">División de Estudios de Posgrado e Investigación</p>
        </div>

        <div style="text-align: center; margin: 0.3cm 0;">
            <p style="font-size: 12px; font-weight: bold; text-decoration: underline; font-style: italic; margin: 2px 0;">
                JURAMENTO DE ÉTICA PROFESIONAL
            </p>
        </div>

        <div style="text-align: justify; margin: 0.3cm 0; font-size: 11px; font-style: italic;">
            <p style="margin: 3px 0;">
                Como <?= Html::encode($alumno->programa->nombre) ?>, de Profesión dedico mis conocimientos profesionales al progreso y al mejoramiento del bienestar humano, me comprometo: a dar un rendimiento máximo, a participar tan solo en empresas dignas, a vivir de acuerdo con las leyes propias del hombre y el más elevado nivel de conducta profesional, a preferir el servicio al provecho, el honor y la calidad de la profesión a la ventaja personal, el bien público a toda consideración.
            </p>
            
            <p style="margin: 3px 0;">
                Con respeto y honradez, hago el presente juramento.
            </p>
        </div>

        <div style="text-align: center; margin-top: 0.5cm;">
            <p style="font-size: 11px; margin: 0;">Villahermosa, Tabasco, a <?= $fechaFormateada ?></p>
        </div>

        <div style="margin-top: 1cm;">
            <table style="width: 100%; font-size: 11px;">
                <tr>
                    <td style="width: 40%; text-align: center;">
                        <p style="border-top: 1px solid black; width: 80%; margin: 0 auto; padding-top: 3px;">
                            <strong>C. <?= Html::encode($alumno->nombreCompleto) ?></strong>
                        </p>
                    </td>
                    <td style="text-align: center;">
                        <p style="margin: 0; font-weight: bold;">JURADO</p>
                    </td>
                </tr>
            </table>
            
            <table style="width: 100%; margin-top: 0.5cm; font-size: 11px;">
                <tr>
                    <td style="width: 30%; text-align: center;">
                        <p style="border-top: 1px solid black; margin: 0 auto; padding-top: 3px;">
                            <strong>PRESIDENTE</strong><br>
                            <?= Html::encode($presidente) ?>
                        </p>
                    </td>
                    <td style="width: 30%; text-align: center;">
                        <p style="border-top: 1px solid black; margin: 0 auto; padding-top: 3px;">
                            <strong>SECRETARIO</strong><br>
                            <?= Html::encode($secretario) ?>
                        </p>
                    </td>
                    <td style="width: 30%; text-align: center;">
                        <p style="border-top: 1px solid black; margin: 0 auto; padding-top: 3px;">
                            <strong>VOCAL</strong><br>
                            <?= Html::encode($vocal) ?>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>