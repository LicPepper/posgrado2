<?php
// --- USO DE NAMESPACES ---
use Mpdf\Mpdf;
use Mpdf\HTMLParserMode;

// --- CONFIGURACIÓN DE RUTAS ---
require_once Yii::getAlias('@vendor/autoload.php');

// --- CONFIGURACIÓN DE RUTAS DE IMÁGENES ---
$basePath = Yii::getAlias('@webroot');
$imgPath = $basePath . '/img/';

// Verificar que la imagen de fondo existe
$fondoPath = $imgPath . 'muejeresTec.png';
if (!file_exists($fondoPath)) {
    Yii::error("La imagen de fondo no existe en la ruta: $fondoPath");
}

// --- CREACIÓN DEL DOCUMENTO mPDF ---
try {
    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'marginTop' => 45,
        'marginBottom' => 30, // Margen suficiente para el pie de página
        'marginHeader' => 10,
        'marginFooter' => 5,  // Espacio entre el contenido del footer y el borde inferior de la página
        'tempDir' => Yii::getAlias('@runtime/mpdf'),
        'default_font' => 'arial'
    ]);
} catch (\Exception $e) {
    die('Error al crear PDF: ' . $e->getMessage());
}

// --- CONFIGURACIÓN DEL FONDO PARA TODAS LAS PÁGINAS ---
$mpdf->SetDefaultBodyCSS('background', "url('$fondoPath') no-repeat center center");
$mpdf->SetDefaultBodyCSS('background-size', 'cover');
$mpdf->SetDefaultBodyCSS('background-image-resize', 6);

// --- DEFINICIÓN DEL ENCABEZADO (HEADER) ---
$headerHtml = '
<table width="100%" style="border-collapse: collapse; font-family: Arial, sans-serif; background: rgba(255,255,255,0.9);">
    <tr>
        <td width="40%" style="vertical-align: top;">
            <img src="' . $imgPath . 'logoTec.png" width="300" />
        </td>
        <td width="45%" style="text-align: right; vertical-align: middle;">
            <div style="font-weight: bold; font-size: 8pt; margin-bottom: 3px;">
                Instituto Tecnológico de Villahermosa
            </div>
            <div style="font-weight: normal; font-size: 8pt;">
                División de Estudios de Posgrado e Investigación
            </div>
        </td>
    </tr>
</table>
';

// --- DEFINICIÓN DEL PIE DE PÁGINA (FOOTER) - SOLUCIÓN CORREGIDA ---
$footerHtml = '
<table width="100%" style="border-collapse: collapse; font-family: arial; font-size: 6.5pt; border-top: 2px solid #9C2142;">
    <tr>
        <td width="40%" style="text-align: left; vertical-align: middle; padding-top: 5px;">
            <div style="line-height: 1.2;">
                Carretera Villahermosa - Frontera Km. 3.5, Ciudad Industrial,<br>
                C.P. 86010, Villahermosa, Tabasco | Tel. 9933530259 / Ext. 230<br>
                E-mail depi_villahermosa@tecnm.mx /<br>
                www.villahermosa.tecnm.mx
            </div>
        </td>
        <td width="60%" style="text-align: right; vertical-align: middle; padding-top: 5px;">
            <div style="line-height: 0;">
                <img src="' . $imgPath . '50aniversario.png" height="45" style="margin-right: 5px;"/>
                <img src="' . $imgPath . 'circulo.png" height="45" style="margin-right: 5px;"/>
                <img src="' . $imgPath . 'plastico.png" height="45" />
            </div>
            <div style="text-align: right; margin-top: 5px; font-size: 6pt;">
                Hoja {PAGENO} de {nbpg}
            </div>
        </td>
    </tr>
</table>
';

// --- APLICAR ENCABEZADO Y PIE DE PÁGINA AL DOCUMENTO ---
$mpdf->SetHTMLHeader($headerHtml);
$mpdf->SetHTMLFooter($footerHtml); // Vuelve a usar el footer de mPDF

// --- CONTENIDO DEL DOCUMENTO ---
$bodyContent = '
<style>
    .content-wrapper {
        background: rgba(255, 255, 255, 0.85) !important;
        padding: 25px;
        border-radius: 8px;
        margin: 30px 20px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    
    .firma-section {
        background: rgba(255, 255, 255, 0.95) !important;
        padding: 20px;
        border-radius: 8px;
        margin-top: 40px;
    }
    
    .texto-importante {
        font-family: Arial, sans-serif;
        font-size: 12pt;
        line-height: 1.6;
    }
</style>

<div class="content-wrapper">
    <h2 style="text-align: center; color: #9C2142; margin-bottom: 30px; font-family: Arial, sans-serif;">
        CONSTANCIA DE INSCRIPCIÓN
    </h2>
    
    <p style="text-align: justify; line-height: 1.6;" class="texto-importante">
        <strong>A QUIEN CORRESPONDA:</strong>
    </p>
    
    <p style="text-align: justify; line-height: 1.6; text-indent: 30px;" class="texto-importante">
        Por medio de la presente se hace constar que el(la) C. <strong>' . $alumnoNombre . '</strong>, 
        con matrícula <strong>' . $alumnoMatricula . '</strong>, está regularmente inscrito(a) 
        en el programa de <strong>' . $alumnoPrograma . '</strong> de esta institución.
    </p>
    
    <p style="text-align: justify; line-height: 1.6; text-indent: 30px;" class="texto-importante">
        Esta constancia se expide a petición del interesado para los fines que estime convenientes.
    </p>
    
    <div style="margin-top: 50px;">
        <p style="text-align: right; font-style: italic;" class="texto-importante">
            Villahermosa, Tabasco, ' . date('d/m/Y') . '
        </p>
    </div>
</div>

<div class="firma-section">
    <p style="text-align: center; margin-bottom: 40px; font-family: Arial, sans-serif;">
        <strong>ATENTAMENTE</strong>
    </p>
    
    <p style="text-align: center; margin-top: 60px; font-family: Arial, sans-serif;">
        __________________________________<br>
        <strong>Nombre del Responsable</strong><br>
        Jefe(a) de la División de Estudios de Posgrado e Investigación<br>
        Instituto Tecnológico de Villahermosa
    </p>
</div>
';

// Escribir el contenido HTML principal en el PDF
$mpdf->WriteHTML($bodyContent);

// --- GENERAR Y MOSTRAR EL PDF ---
$filename = 'constancia_' . $alumnoMatricula . '_' . date('YmdHis') . '.pdf';
$mpdf->Output($filename, 'I');

exit;