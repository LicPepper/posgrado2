<?php

namespace app\controllers;

use app\models\Alumno;
use app\models\AlumnoSearch;
use app\models\AvanceAlumno;
use app\models\DocumentoGenerado;
use app\models\PlantillaDocumento;
use app\models\Requisito;
use app\models\Revisor;
use app\models\RevisorTesis;
use Mpdf\Mpdf;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class AlumnoController extends Controller
{
/****************************************************************
* Configura los comportamientos del controlador (ACL y verbos) *
****************************************************************/
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'generar-pdf' => ['POST'],
                ],
            ],
        ];
    }
/**************************************************************
* Verifica si el usuario tiene permisos para una acción dada  *
* @param string $accion La acción a verificar permisos        *
* @throws \yii\web\ForbiddenHttpException Si no tiene permisos*
***************************************************************/
    protected function checkAccess($accion)
    {
        $user = Yii::$app->user->identity;
        
        if (!$user || !$user->puede($accion)) {
            throw new \yii\web\ForbiddenHttpException('No tienes permisos para realizar esta acción.');
        }
    }   
/***************************************************************
* Ejecuta antes de cada acción para verificar permisos        *
* @param \yii\base\Action $action La acción a ejecutar        *
* @return bool Si se permite continuar con la acción          *
****************************************************************/
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $permisos = [
            'index' => 'ver',
            'view' => 'ver',
            'create' => 'crear',
            'update' => 'editar',
            'delete' => 'eliminar',
        ];

        if (isset($permisos[$action->id])) {
            $this->checkAccess($permisos[$action->id]);
        }

        return true;
    }
/****************************************
* Muestra una lista de todos los alumnos*
*****************************************/
    public function actionIndex()
    {
        $searchModel = new AlumnoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
/**********************************************
     * Muestra los detalles de un alumno específico*
     ***********************************************/
    public function actionView($id)
    {
        // Cargar el modelo con la relación programa
        $model = Alumno::find()->with('programa')->where(['id' => $id])->one();
        
        if (!$model) {
            throw new NotFoundHttpException('El alumno no existe');
        }

        $tienePendientes = AvanceAlumno::find()
            ->joinWith('requisito', false)
            ->where([
                'avancealumno.alumno_id' => $id,
                'avancealumno.completado' => 0,
                'requisito.obligatorio' => 1
            ])->exists();

        return $this->render('view', [
            'model' => $model,
            'puedeGenerar' => !$tienePendientes,
        ]);
    }

/*************************************************************
* Busca alumnos por término en matrícula, nombre o programa  *
* @return string Vista de resultados de búsqueda             *
**************************************************************/
    public function actionBuscar()
    {
        $searchModel = new AlumnoSearch();
        
        $terminoBusqueda = Yii::$app->request->get('termino') ?? '';
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if (!empty($terminoBusqueda)) {
            $dataProvider->query->andWhere([
                'or',
                ['like', 'matricula', $terminoBusqueda],
                ['like', 'nombre', $terminoBusqueda],
                ['like', 'apellido_paterno', $terminoBusqueda],
                ['like', 'apellido_materno', $terminoBusqueda],
                ['like', 'programa.nombre', $terminoBusqueda]
            ])->joinWith('programa'); 
        }

        return $this->render('buscar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'terminoBusqueda' => $terminoBusqueda
        ]);
    }
/**********************
* Crea un nuevo alumno*
***********************/
public function actionCreate()
    {
        $model = new Alumno();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Alumno creado exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        $model->loadDefaultValues();
        return $this->render('create', ['model' => $model]);
    }
/******************************
*Actualiza un alumno existente*
*******************************/
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Alumno actualizado exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }
/*****************************
* Elimina un alumno existente*
******************************/
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Alumno eliminado exitosamente.');
        return $this->redirect(['index']);
    }
/****************************************************************
* Punto de entrada para la generación de documentos pdf via AJAX*
*****************************************************************/
    public function actionGenerarPdf()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        try {
            $id = Yii::$app->request->post('id');
            $tipoDocumento = Yii::$app->request->post('tipo_documento');

            if (!$id) {
                throw new \Exception('ID de alumno no proporcionado.');
            }

            $alumno = $this->findModel($id); // findModel ya lanza excepción si no lo encuentra.

            if ($tipoDocumento === 'revisores') {
                return $this->generarDocumentosRevisores($alumno, true);
            }
            // Aquí iría la lógica para otros tipos de documentos si fuera necesario.
            throw new \Exception('Tipo de documento no soportado.');

        } catch (\Exception $e) {
            Yii::error("Error al generar PDF: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return ['success' => false, 'error' => 'Error: ' . $e->getMessage()];
        }
    }
/**********************************************************
* Asigna o actualiza los revisores de tesis para un alumno*
***********************************************************/
    public function actionAsignarRevisores($id)
    {
        $alumno = $this->findModel($id);
        $revisores = Revisor::find()->where(['activo' => 1])->all();
        
        // Obtener los IDs de revisores ya asignados
        $selectedRevisores = ArrayHelper::getColumn($alumno->revisorTesis, 'revisor_id');

        if (Yii::$app->request->isPost) {
            $selectedRevisores = Yii::$app->request->post('revisores', []);
            
            if (count($selectedRevisores) !== 4) {
                Yii::$app->session->setFlash('error', 'Debe seleccionar exactamente 4 revisores.');
            } else {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // Eliminar asignaciones anteriores
                    RevisorTesis::deleteAll(['alumno_id' => $id]);
                    
                    // Crear nuevas asignaciones
                    foreach ($selectedRevisores as $revisorId) {
                        $asignacion = new RevisorTesis([
                            'alumno_id' => $id,
                            'revisor_id' => $revisorId,
                        ]);
                        if (!$asignacion->save()) {
                            throw new \Exception('Error al guardar la asignación.');
                        }
                    }
                    
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Revisores asignados correctamente.');
                    return $this->refresh();

                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
                }
            }
        }

        return $this->render('asignar_revisores', [
            'alumno' => $alumno,
            'revisores' => $revisores,
            'revisoresAsignados' => $selectedRevisores
        ]);
    }
/*******************************************************************************
* Genera las 4 cartas de nombramiento de revisor, una por cada revisor asignado*
* y la notificación al alumno                                                  *
* @param Alumno $alumno El alumno para el cual generar documentos              *
* @param bool $returnJson Si retorna JSON o redirecciona                       *
* @return array|\yii\web\Response                                              *
********************************************************************************/
    private function generarDocumentosRevisores($alumno, $returnJson = false)
    {
        $revisoresAsignados = RevisorTesis::find()->where(['alumno_id' => $alumno->id])->all();
        $revisores = [];
        foreach ($revisoresAsignados as $asignacion) {
            if ($revisor = Revisor::findOne($asignacion->revisor_id)) {
                $revisores[] = $revisor;
            }
        }

        if (count($revisores) !== 4) {
            $error = 'Debe asignar exactamente 4 revisores para generar los documentos.';
            return $returnJson ? ['success' => false, 'error' => $error] : Yii::$app->session->setFlash('error', $error) && $this->redirect(['asignar-revisores', 'id' => $alumno->id]);
        }

        $tituloTesis = $alumno->titulo_tesis ?? "Tesis no definida";
        $documentosDir = Yii::getAlias('@webroot/documentos');
        if (!is_dir($documentosDir)) {
            mkdir($documentosDir, 0777, true);
        }

        // Configuración de la imagen de fondo
        $fondoPath = Yii::getAlias('@webroot/img/fondo.jpg');
        
        $documentos001 = [];
        
        // Generar documentos 001 (cartas individuales para revisores)
        foreach ($revisores as $index => $revisor) {
            $numeroOficio = $this->generarNumeroOficio('Asignación Revisor Individual');
            
            // Generar contenido HTML para la carta de revisor
            $html = $this->renderPartial('@app/views/documentoGenerado/_carta-revisor', [
                'alumno' => $alumno,
                'revisor' => $revisor,
                'numeroOficio' => $numeroOficio,
                'tituloTesis' => $tituloTesis
            ]);

            $nombreArchivo = "001_CARTA_REVISOR_" . preg_replace('/[^a-zA-Z0-9]/', '_', $revisor->nombre) . "_{$alumno->matricula}_" . time() . "_{$index}.pdf";
            $rutaArchivo = '/documentos/' . $nombreArchivo;
            $rutaCompleta = Yii::getAlias('@webroot') . $rutaArchivo;

            // Configurar y generar PDF
            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'marginTop' => 25,
                'marginBottom' => 25,
                'marginLeft' => 20,
                'marginRight' => 20,
                'tempDir' => Yii::getAlias('@runtime/mpdf'),
                'default_font' => 'times'
            ]);

            // Agregar imagen de fondo
            if (file_exists($fondoPath)) {
                $pdf->SetDefaultBodyCSS('background', "url('$fondoPath') no-repeat center center");
                $pdf->SetDefaultBodyCSS('background-size', 'cover');
                $pdf->SetDefaultBodyCSS('background-image-resize', 6);
            }

            $pdf->WriteHTML($html);
            $pdf->Output($rutaCompleta, \Mpdf\Output\Destination::FILE);

            $plantilla = PlantillaDocumento::findOne(['nombre' => 'Carta Revisor Individual']) ?: new PlantillaDocumento([
                'nombre' => 'Carta Revisor Individual', 
                'tipo' => 'Constancia', 
                'contenido' => 'Plantilla para carta de revisor', 
                'activo' => 1
            ]);
            
            if ($plantilla->isNewRecord && !$plantilla->save()) {
                throw new \Exception('Error al crear la plantilla base: ' . json_encode($plantilla->errors));
            }

            $documento = new DocumentoGenerado([
                'alumno_id' => $alumno->id, 
                'plantilla_id' => $plantilla->id, 
                'ruta_archivo' => $rutaArchivo,
                'hash_verificacion' => md5_file($rutaCompleta), 
                'fecha_generacion' => date('Y-m-d H:i:s'),
                'generado_por' => Yii::$app->user->id, 
                'version' => 1, 
                'estado' => DocumentoGenerado::ESTADO_GENERADO,
            ]);
            
            if (!$documento->save()) {
                if (file_exists($rutaCompleta)) { unlink($rutaCompleta); }
                throw new \Exception('Error al guardar el documento en la base de datos: ' . json_encode($documento->errors));
            }

            $documentos001[] = [
                'viewUrl' => Url::to(['/documento-generado/view-pdf', 'id' => $documento->id], true),
                'downloadUrl' => Url::to(['/documento-generado/download', 'id' => $documento->id], true),
                'documentoId' => $documento->id, 
                'revisorNombre' => $revisor->nombre,
            ];
        }

        // Generar documento 002 (notificación al alumno)
        $numeroOficio002 = $this->generarNumeroOficio('Asignación Revisores');
        
        // Generar contenido HTML para la notificación al alumno
        $html002 = $this->renderPartial('@app/views/documentoGenerado/_asignar-revisores', [
            'alumno' => $alumno,
            'revisores' => $revisores,
            'numeroOficio' => $numeroOficio002
        ]);

        $nombreArchivo002 = "002_NOTIFICACION_ALUMNO_{$alumno->matricula}_" . time() . ".pdf";
        $rutaArchivo002 = '/documentos/' . $nombreArchivo002;
        $rutaCompleta002 = Yii::getAlias('@webroot') . $rutaArchivo002;

        $pdf002 = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'marginTop' => 25,
            'marginBottom' => 20,
            'marginLeft' => 15,
            'marginRight' => 15,
            'tempDir' => Yii::getAlias('@runtime/mpdf'),
            'default_font' => 'times'
        ]);

        // Agregar imagen de fondo al segundo documento
        if (file_exists($fondoPath)) {
            $pdf002->SetDefaultBodyCSS('background', "url('$fondoPath') no-repeat center center");
            $pdf002->SetDefaultBodyCSS('background-size', 'cover');
            $pdf002->SetDefaultBodyCSS('background-image-resize', 6);
        }

        $pdf002->WriteHTML($html002);
        $pdf002->Output($rutaCompleta002, \Mpdf\Output\Destination::FILE);

        $plantilla002 = PlantillaDocumento::findOne(['nombre' => 'Asignación Revisores - Notificación Alumno']) ?: new PlantillaDocumento([
            'nombre' => 'Asignación Revisores - Notificación Alumno', 
            'tipo' => 'Constancia', 
            'contenido' => 'Plantilla para notificación de asignación de revisores al alumno', 
            'activo' => 1
        ]);
        
        if ($plantilla002->isNewRecord && !$plantilla002->save()) {
            throw new \Exception('Error al crear la plantilla base: ' . json_encode($plantilla002->errors));
        }

        $documento002 = new DocumentoGenerado([
            'alumno_id' => $alumno->id, 
            'plantilla_id' => $plantilla002->id, 
            'ruta_archivo' => $rutaArchivo002,
            'hash_verificacion' => md5_file($rutaCompleta002), 
            'fecha_generacion' => date('Y-m-d H:i:s'),
            'generado_por' => Yii::$app->user->id, 
            'version' => 1, 
            'estado' => DocumentoGenerado::ESTADO_GENERADO,
        ]);
        
        if (!$documento002->save()) {
            if (file_exists($rutaCompleta002)) { unlink($rutaCompleta002); }
            throw new \Exception('Error al guardar el documento en la base de datos: ' . json_encode($documento002->errors));
        }

        $documento002Data = [
            'viewUrl' => Url::to(['/documento-generado/view-pdf', 'id' => $documento002->id], true),
            'downloadUrl' => Url::to(['/documento-generado/download', 'id' => $documento002->id], true),
            'documentoId' => $documento002->id,
        ];
        
        if ($returnJson) {
            return [
                'success' => true, 
                'documentos001' => $documentos001, 
                'documento002' => $documento002Data,
                'message' => 'Documentos generados correctamente.'
            ];
        }
        
        Yii::$app->session->setFlash('success', 'Documentos generados correctamente.');
        Yii::$app->session->setFlash('documentos001', $documentos001);
        Yii::$app->session->setFlash('documento002', $documento002Data);
        return $this->redirect(['view', 'id' => $alumno->id]);
    }

    /***********************************************
     * Genera un número de oficio único y secuencial*
     * @param string $tipo El tipo de documento     *
     * @return string Número de oficio generado     *
     ************************************************/
    private function generarNumeroOficio($tipo)
    {
        $prefix = 'DEPI';
        $year = date('Y');
        $correlativo = DocumentoGenerado::find()->where(['YEAR(fecha_generacion)' => $year])->count() + 1;

        $offset = 0;
        switch ($tipo) {
            case 'Asignación Revisor Individual': $offset = 100; break;
            case 'Asignación Revisores': $offset = 500; break;
            case 'LiberacionIngles': $offset = 500; break;
            case 'LiberacionTesis': $offset = 600; break;
            case 'Estancia': $offset = 700; break;
        }

        return sprintf("%s/%04d/%d", $prefix, $offset + $correlativo, $year);
    }

    /**************************************************
     * Encuentra un modelo Alumno por su clave primaria*
     * Si no se encuentra, lanza una excepción HTTP 404*
     * @param int $id ID del alumno                   *
     * @return Alumno El modelo encontrado            *
     ***************************************************/
    protected function findModel($id)
    {
        if (($model = Alumno::find()->with('programa')->where(['id' => $id])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('La página solicitada no existe.');
    }

    /***************************************
     * Gestiona los requisitos de un alumno*
     * @param int $id ID del alumno        *
     * @return string Vista de gestión     *
     ***************************************/
    public function actionGestionarRequisitos($id)
    {
        $alumno = $this->findModel($id);
        $requisitos = \app\models\Requisito::find()
            ->where(['obligatorio' => 1])
            ->orderBy(['tipo_documento' => SORT_ASC, 'orden' => SORT_ASC])
            ->all();

        if (Yii::$app->request->isPost) {
            $requisitosCompletados = Yii::$app->request->post('requisitos', []);
            
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Actualizar todos los requisitos
                foreach ($requisitos as $requisito) {
                    $avance = \app\models\AvanceAlumno::find()
                        ->where(['alumno_id' => $id, 'requisito_id' => $requisito->id])
                        ->one();
                    
                    if (!$avance) {
                        $avance = new \app\models\AvanceAlumno();
                        $avance->alumno_id = $id;
                        $avance->requisito_id = $requisito->id;
                    }
                    
                    $avance->completado = in_array($requisito->id, $requisitosCompletados) ? 1 : 0;
                    $avance->fecha_completado = $avance->completado ? date('Y-m-d H:i:s') : null;
                    $avance->validado_por = Yii::$app->user->id;
                    
                    if (!$avance->save()) {
                        throw new \Exception('Error al guardar requisito: ' . json_encode($avance->errors));
                    }
                }
                
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Requisitos actualizados correctamente.');
                return $this->redirect(['view', 'id' => $id]); // Redirigir a view en lugar de refresh
                
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
            }
        }

        // Obtener estado actual de los requisitos para mostrar en la vista
        $requisitosEstado = [];
        foreach ($requisitos as $requisito) {
            $avance = \app\models\AvanceAlumno::find()
                ->where(['alumno_id' => $id, 'requisito_id' => $requisito->id])
                ->one();
            
            $requisitosEstado[$requisito->id] = $avance ? $avance->completado : 0;
        }

        // Renderizar la vista validar.php que ya existe
        return $this->render('validar', [
            'model' => $alumno,  
            'requisitos' => $requisitos,
        ]);
    }

    /************************************************
     * Muestra el formulario para validar requisitos*
     * @param int $id ID del alumno                 *
     * @return string Vista de validación           *
     ************************************************/
    public function actionValidarRequisitos($id)
    {
        $model = $this->findModel($id);
        $requisitos = \app\models\Requisito::find()
            ->where(['obligatorio' => 1])
            ->orderBy(['tipo_documento' => SORT_ASC, 'orden' => SORT_ASC])
            ->all();

        return $this->render('validar', [
            'model' => $model,
            'requisitos' => $requisitos,
        ]);
    }

    /****************************************************
     * Genera una constancia para el alumno especificado*
     * @param int $id ID del alumno                     *
     ****************************************************/
    public function actionGenerarConstancia($id)
    {
        $alumno = $this->findModel($id);
        $this->checkAccess('editar');
        
        // Extraer variables para la vista
        extract([
            'alumnoNombre' => $alumno->nombre . ' ' . $alumno->apellido_paterno . ' ' . $alumno->apellido_materno,
            'alumnoMatricula' => $alumno->matricula,
            'alumnoPrograma' => $alumno->programa->nombre ?? 'Programa no especificado'
        ]);
        
        require_once Yii::getAlias('@app/views/documentoGenerado/_constancia.php');
        return;
    }
}