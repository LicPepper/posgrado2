<?php

namespace app\controllers;

use Yii;
use app\models\DocumentoGenerado;
use app\models\DocumentoGeneradoSearch;
use app\models\Alumno;
use app\models\PlantillaDocumento;
use app\models\AvanceAlumno;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use yii\helpers\Url;
use \Exception;

/**
 * DocumentoGeneradoController implementa las acciones CRUD para el modelo DocumentoGenerado.
 */
class DocumentoGeneradoController extends Controller
{
    public $viewPath = '@app/views/DocumentoGenerado';
    
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => \yii\filters\AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lista todos los documentos generados
     */
    public function actionIndex()
    {
        $searchModel = new DocumentoGeneradoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@app/views/DocumentoGenerado/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un documento específico
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        if (!file_exists(Yii::getAlias('@webroot') . $model->ruta_archivo)) {
            Yii::$app->session->setFlash('error', 'El archivo PDF no existe en el servidor');
            return $this->redirect(['index']);
        }
        
        return $this->render('@app/views/DocumentoGenerado/view', [
            'model' => $model,
        ]);
    }

    /**
     * Acción principal para generar documentos PDF
     */
    public function actionGenerar()
    {
        Yii::info("Iniciando generación de documento", 'app');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        try {
            $request = Yii::$app->request;
            $alumnoId = $request->post('alumno_id');
            $tipoDocumento = $request->post('tipo_documento');
            
            Yii::info("Datos recibidos - alumnoId: $alumnoId, tipoDocumento: $tipoDocumento", 'app');

            // Validaciones básicas
            if (empty($alumnoId)) {
                throw new \Exception('Debe seleccionar un alumno');
            }

            $alumno = Alumno::findOne($alumnoId);
            if (!$alumno) {
                throw new \Exception('Alumno no encontrado');
            }

            // Validar requisitos antes de continuar
            $errorRequisitos = $this->validarRequisitos($tipoDocumento, $alumno);
            if ($errorRequisitos) {
                throw new \Exception($errorRequisitos);
            }

            // Mapeo flexible de tipos de documento
            $mapeoTipos = [
                'LiberacionIngles' => ['Liberación Inglés', 'LiberacionIngles', 'Inglés'],
                'LiberacionTesis' => ['Liberación Tesis', 'LiberacionTesis', 'Tesis'],
                'Estancia' => ['Estancia', 'Carta de Estancia'],
                'Constancia' => ['Constancia'],
                'Kardex' => ['Kardex']
            ];

            // Búsqueda de plantilla
            $plantilla = $this->buscarPlantilla($tipoDocumento, $mapeoTipos, $alumno);
            if (!$plantilla) {
                throw new \Exception("No se encontró plantilla para el tipo: $tipoDocumento");
            }

            // Configuración común
            $fechaActual = date('d/m/Y');
            $numeroOficio = $this->generarNumeroOficio($tipoDocumento);
            
            // Parámetros base
            $params = [
                'alumno' => $alumno,
                'fecha' => $fechaActual,
                'numeroOficio' => $numeroOficio
            ];

            // Parámetros específicos por tipo de documento
            $view = $this->obtenerVistaPorTipo($tipoDocumento, $request, $alumno, $params);

            // Configurar directorios
            $this->verificarDirectorios();

            // Configuración de mPDF
            $pdf = $this->configurarMPdf();

            // Renderizar contenido PDF
            Yii::info("Renderizando vista: $view", 'app');
            $pdfContent = $this->renderPartial("@app/views/documentoGenerado/{$view}", $params);
            $pdf->WriteHTML($pdfContent);

            // Generar nombre de archivo único
            $nombreArchivo = "doc_{$tipoDocumento}_{$alumno->matricula}_".time().'.pdf';
            $rutaArchivo = "/documentos/{$nombreArchivo}";
            $rutaCompleta = Yii::getAlias('@webroot') . $rutaArchivo;
            
            // Guardar archivo
            Yii::info("Guardando archivo en: $rutaCompleta", 'app');
            $pdf->Output($rutaCompleta, \Mpdf\Output\Destination::FILE);

            // Registrar en base de datos
            $documento = $this->guardarDocumentoBD($alumno, $plantilla, $rutaArchivo, $rutaCompleta);

            Yii::info("Documento generado exitosamente: ID {$documento->id}", 'app');
            return [
                'success' => true,
                'pdfUrl' => Url::to(['/documento-generado/stream', 'id' => $documento->id], true),
                'downloadUrl' => Url::to(['/documento-generado/download', 'id' => $documento->id], true),
                'documentoId' => $documento->id,
                'historialUrl' => Url::to(['/documento-generado/ver-historia', 'alumno_id' => $alumno->id], true)
            ];

        } catch (\Exception $e) {
            Yii::error("Error al generar documento: " . $e->getMessage() . "\n" . $e->getTraceAsString(), 'app');
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'technical' => YII_DEBUG ? $e->getTraceAsString() : null
            ];
        }
    }

    /**
     * Busca plantilla por tipo de documento
     */
    private function buscarPlantilla($tipoDocumento, $mapeoTipos, $alumno)
    {
        if (isset($mapeoTipos[$tipoDocumento])) {
            foreach ($mapeoTipos[$tipoDocumento] as $variacion) {
                $plantilla = PlantillaDocumento::find()
                    ->where(['tipo' => $variacion])
                    ->andWhere(['OR', 
                        ['programa_id' => $alumno->programa_id],
                        ['programa_id' => null]
                    ])
                    ->one();
                if ($plantilla) return $plantilla;
            }
        }
        return null;
    }

    /**
     * Obtiene la vista según el tipo de documento
     */
    private function obtenerVistaPorTipo($tipoDocumento, $request, $alumno, &$params)
    {
        switch ($tipoDocumento) {
            case 'LiberacionIngles':
                $params['articulo'] = $request->post('articulo', 'Artículo de investigación en inglés');
                return '_liberacion-ingles';
                
            case 'Estancia':
                $params['fechaInicio'] = $request->post('fecha_inicio', date('d/m/Y'));
                $params['fechaFin'] = $request->post('fecha_fin', date('d/m/Y', strtotime('+1 month')));
                $params['asesor'] = $request->post('asesor', 'MCIB. Juana Selvan García');
                $params['proyecto'] = $request->post('proyecto', 'Tesis de '.$alumno->programa->nombre);
                return '_estancia';
                
            case 'Constancia':
                return '_constancia';
                
            case 'LiberacionTesis':
                return '_liberaciontesis';
                
            default:
                throw new \Exception('Tipo de documento no válido');
        }
    }

    /**
     * Guarda documento en base de datos
     */
    private function guardarDocumentoBD($alumno, $plantilla, $rutaArchivo, $rutaCompleta)
    {
        $documento = new DocumentoGenerado();
        $documento->alumno_id = $alumno->id;
        $documento->plantilla_id = $plantilla->id;
        $documento->ruta_archivo = $rutaArchivo;
        $documento->hash_verificacion = md5_file($rutaCompleta);
        $documento->fecha_generacion = date('Y-m-d H:i:s');
        $documento->generado_por = Yii::$app->user->id;
        $documento->version = 1;
        $documento->estado = DocumentoGenerado::ESTADO_GENERADO;
        
        if (!$documento->save()) {
            // Eliminar archivo si falla el guardado en BD
            if (file_exists($rutaCompleta)) {
                unlink($rutaCompleta);
            }
            throw new \Exception('Error al guardar documento: ' . json_encode($documento->errors));
        }
        
        return $documento;
    }

   /**
 * Valida requisitos específicos para cada tipo de documento
 */
private function validarRequisitos($tipo, $alumno)
{
    // Obtener requisitos específicos para este tipo de documento
    $requisitosDocumento = \app\models\Requisito::getRequisitosPorTipo($tipo);
    
    $errores = [];
    
    foreach ($requisitosDocumento as $requisito) {
        if ($requisito->obligatorio) {
            $cumple = \app\models\AvanceAlumno::find()
                ->where([
                    'alumno_id' => $alumno->id,
                    'requisito_id' => $requisito->id,
                    'completado' => 1
                ])
                ->exists();
            
            if (!$cumple) {
                $errores[] = $requisito->nombre;
            }
        }
    }
    
    if (!empty($errores)) {
        return 'Requisitos obligatorios pendientes: ' . implode(', ', $errores);
    }

    return null;
}

private function verificarRequisitoEspecifico($requisito, $alumno)
{
    // Lógica para verificar requisitos específicos
    switch ($requisito->nombre) {
        case 'Revisores asignados':
            $countRevisores = \app\models\RevisorTesis::find()
                ->where(['alumno_id' => $alumno->id])
                ->count();
            return $countRevisores === 4;
            
        case 'Tesis completada':
            return !empty($alumno->titulo_tesis);
            
        case 'Dictamen de revisores':
            // Aquí implementarías la lógica para verificar el dictamen
            // Por ahora, asumimos que está aprobado si hay revisores asignados
            $countRevisores = \app\models\RevisorTesis::find()
                ->where(['alumno_id' => $alumno->id])
                ->count();
            return $countRevisores === 4;
            
        case 'Aprobación de sinodales':
            // Similar al anterior
            $countRevisores = \app\models\RevisorTesis::find()
                ->where(['alumno_id' => $alumno->id])
                ->count();
            return $countRevisores === 4;
            
        default:
            // Para requisitos genéricos, verificar en avancealumno
            return \app\models\AvanceAlumno::find()
                ->where([
                    'alumno_id' => $alumno->id,
                    'requisito_id' => $requisito->id,
                    'completado' => 1
                ])
                ->exists();
    }
}
    /**
     * Configura mPDF con opciones optimizadas
     */
    private function configurarMPdf()
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        return new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 25,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
            'tempDir' => Yii::getAlias('@runtime/mpdf'),
            'fontDir' => array_merge($fontDirs, [
                Yii::getAlias('@webroot/fonts'),
            ]),
            'fontdata' => $fontData + [
                'arial' => [
                    'R' => 'arial.ttf',
                    'B' => 'arialbd.ttf',
                ],
                'times' => [
                    'R' => 'times.ttf',
                    'B' => 'timesbd.ttf',
                ],
            ],
            'default_font' => 'arial',
            'orientation' => 'P',
        ]);
    }

    /**
     * Verifica y crea los directorios necesarios
     */
    private function verificarDirectorios()
    {
        $documentosDir = Yii::getAlias('@webroot/documentos');
        $tempDir = Yii::getAlias('@runtime/mpdf');

        if (!file_exists($documentosDir)) {
            Yii::info("Creando directorio de documentos: $documentosDir", 'app');
            if (!mkdir($documentosDir, 0777, true)) {
                throw new \Exception("No se pudo crear el directorio: $documentosDir");
            }
        }

        if (!file_exists($tempDir)) {
            Yii::info("Creando directorio temporal: $tempDir", 'app');
            if (!mkdir($tempDir, 0777, true)) {
                throw new \Exception("No se pudo crear el directorio temporal: $tempDir");
            }
        }

        if (!is_writable($documentosDir)) {
            throw new \Exception("El directorio $documentosDir no tiene permisos de escritura");
        }

        if (!is_writable($tempDir)) {
            throw new \Exception("El directorio temporal $tempDir no tiene permisos de escritura");
        }
    }

    /**
     * Genera número de oficio automático
     */
    public function generarNumeroOficio($tipo)
    {
        $prefix = 'DEPI';
        $year = date('Y');
        $correlativo = DocumentoGenerado::find()
            ->where(['YEAR(fecha_generacion)' => $year])
            ->count() + 1;

        switch ($tipo) {
            case 'LiberacionIngles': 
                return sprintf("%s/%04d/%d", $prefix, 500 + $correlativo, $year);
            case 'LiberacionTesis': 
                return sprintf("%s/%04d/%d", $prefix, 600 + $correlativo, $year);
            case 'Estancia': 
                return sprintf("%s/%04d/%d", $prefix, 700 + $correlativo, $year);
            default: 
                return sprintf("%s/%04d/%d", $prefix, $correlativo, $year);
        }
    }

    /**
     * Muestra el PDF en el navegador
     */
    public function actionViewPdf($id)
    {
        $documento = $this->findModel($id);
        $filePath = Yii::getAlias('@webroot') . $documento->ruta_archivo;
        
        if (!file_exists($filePath)) {
            throw new \yii\web\NotFoundHttpException('El archivo no existe');
        }

        return $this->renderPartial('@app/views/DocumentoGenerado/_pdf-viewer', [
            'id' => $id
        ]);
    }  

    /**
     * Stream del PDF para visualización en navegador
     */
    public function actionStream($id)
    {
        $documento = $this->findModel($id);
        $filePath = Yii::getAlias('@webroot') . $documento->ruta_archivo;
        
        if (!file_exists($filePath)) {
            throw new \yii\web\NotFoundHttpException('El archivo no existe');
        }

        // Configurar headers para visualización en el navegador
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'application/pdf');
        Yii::$app->response->headers->set('Content-Disposition', 'inline; filename="' . basename($filePath) . '"');
        Yii::$app->response->headers->set('Content-Length', filesize($filePath));
        Yii::$app->response->headers->set('Cache-Control', 'public, must-revalidate, max-age=0');
        
        return file_get_contents($filePath);
    }

    /**
     * Descarga el PDF
     */
    public function actionDownload($id)
    {
        $documento = $this->findModel($id);
        $filePath = Yii::getAlias('@webroot') . $documento->ruta_archivo;
        
        if (!file_exists($filePath)) {
            throw new \yii\web\NotFoundHttpException('El archivo no existe');
        }

        return Yii::$app->response->sendFile($filePath, basename($filePath), [
            'inline' => false // Forzar descarga
        ]);
    }

    /**
     * Muestra el historial de documentos de un alumno
     */
    public function actionVerHistoria($alumno_id)
    {
        $alumno = Alumno::findOne($alumno_id);
        if (!$alumno) {
            throw new NotFoundHttpException('El alumno no existe');
        }

        $documentos = DocumentoGenerado::find()
            ->where(['alumno_id' => $alumno_id])
            ->orderBy(['fecha_generacion' => SORT_DESC])
            ->all();

        return $this->render('@app/views/DocumentoGenerado/historial', [
            'alumno' => $alumno,
            'documentos' => $documentos
        ]);
    }

    /**
     * Encuentra el modelo DocumentoGenerado basado en su ID
     */
    protected function findModel($id)
    {
        if (($model = DocumentoGenerado::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionDelete($id)
{
    // 1. Encontrar el registro del documento en la base de datos.
    $model = $this->findModel($id);
    // Guardamos el ID del alumno para poder redirigir de vuelta a su historial.
    $alumnoId = $model->alumno_id;

    // 2. Construir la ruta absoluta al archivo PDF en el servidor.
    $filePath = Yii::getAlias('@webroot') . $model->ruta_archivo;

    // 3. Borrar el archivo físico del servidor, solo si existe.
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // 4. Borrar el registro de la base de datos.
    if ($model->delete()) {
        Yii::$app->session->setFlash('success', 'El documento ha sido eliminado exitosamente.');
    } else {
        Yii::$app->session->setFlash('error', 'No se pudo eliminar el registro del documento de la base de datos.');
    }

    // 5. Redirigir de vuelta a la VISTA DEL HISTORIAL del alumno.
    return $this->redirect(['ver-historia', 'alumno_id' => $alumnoId]);
}
/**
 * Elimina múltiples documentos generados de forma masiva.
 * @return \yii\web\Response
 */
public function actionBulkDelete()
{
    // Se espera que los datos lleguen por POST
    $request = Yii::$app->request;
    $alumnoId = $request->post('alumno_id');
    $selection = $request->post('selection', []); // IDs de los documentos a borrar

    if (empty($selection)) {
        Yii::$app->session->setFlash('warning', 'No has seleccionado ningún documento para eliminar.');
        return $this->redirect(['ver-historia', 'alumno_id' => $alumnoId]);
    }

    // Usamos una transacción para asegurar que todo se complete o nada se haga.
    $transaction = Yii::$app->db->beginTransaction();
    try {
        // Encontramos todos los documentos que coinciden con los IDs seleccionados
        $documentos = DocumentoGenerado::findAll(['id' => $selection]);
        $archivosEliminados = 0;
        
        foreach ($documentos as $documento) {
            $filePath = Yii::getAlias('@webroot') . $documento->ruta_archivo;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $archivosEliminados++;
        }

        // Eliminamos todos los registros de la base de datos en una sola consulta
        DocumentoGenerado::deleteAll(['id' => $selection]);

        $transaction->commit();
        Yii::$app->session->setFlash('success', "Se eliminaron $archivosEliminados documentos exitosamente.");

    } catch (\Exception $e) {
        $transaction->rollBack();
        Yii::$app->session->setFlash('error', 'Ocurrió un error al intentar eliminar los documentos: ' . $e->getMessage());
    }

    // Redirigimos de vuelta al historial del alumno
    return $this->redirect(['ver-historia', 'alumno_id' => $alumnoId]);
}
}