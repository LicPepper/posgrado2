<?php

namespace app\controllers;

use app\models\Alumno;
use app\models\AlumnoSearch;
use app\models\AvanceAlumno;
use app\models\DocumentoGenerado;
use app\models\Requisito; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Yii;

class AlumnoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'generar-pdf' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new AlumnoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $pendientes = AvanceAlumno::find()
            ->joinWith('requisito')
            ->where([
                'alumno_id' => $id,
                'completado' => 0,
                'requisito.obligatorio' => 1
            ])->count();
            
        $puedeGenerar = ($pendientes === 0);

        return $this->render('view', [
            'model' => $model,
            'puedeGenerar' => $puedeGenerar,
        ]);
    }

     public function actionCreate()
    {
        $model = new Alumno();

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionGenerarPdf()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    try {
        $id = Yii::$app->request->post('id');
        if (empty($id)) {
            throw new \Exception('ID de alumno no proporcionado');
        }

        $alumno = $this->findModel($id);
        if (!$alumno) {
            throw new \Exception('Alumno no encontrado');
        }

        // 1. Verificación de requisitos obligatorios
        $pendientes = AvanceAlumno::find()
            ->joinWith('requisito')
            ->where([
                'alumno_id' => $id,
                'completado' => 0,
                'requisito.obligatorio' => 1
            ])
            ->all();

        if (!empty($pendientes)) {
            $listaPendientes = array_map(function($item) {
                return $item->requisito->nombre;
            }, $pendientes);
            
            return [
                'success' => false,
                'error' => 'No se puede generar el documento. Faltan requisitos obligatorios:',
                'requisitos_pendientes' => $listaPendientes
            ];
        }

        // 2. Configuración de PDF
        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontDirs = (new ConfigVariables())->getDefaults()['fontDir'];
        
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'fontDir' => array_merge($fontDirs, [
                Yii::getAlias('@webroot/fonts'),
            ]),
            'fontdata' => [
                'arial' => [
                    'R' => 'arial.ttf',
                ],
            ],
            'default_font' => 'arial',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 25,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        // 3. Renderizar contenido PDF
        $pdfContent = $this->renderPartial('_documentoPdf', [
            'model' => $alumno,
            'requisitos' => $alumno->avanceAlumnos
        ]);

        $pdf->WriteHTML($pdfContent);

        // 4. Guardar archivo PDF
        $documentosDir = Yii::getAlias('@webroot/documentos');
        if (!file_exists($documentosDir)) {
            if (!mkdir($documentosDir, 0777, true)) {
                throw new \Exception('No se pudo crear el directorio para documentos');
            }
        }
        
        $nombreArchivo = 'documento_' . $alumno->matricula . '_' . date('YmdHis') . '.pdf';
        $rutaArchivo = '/documentos/' . $nombreArchivo;
        $rutaCompleta = Yii::getAlias('@webroot') . $rutaArchivo;
        
        $pdf->Output($rutaCompleta, \Mpdf\Output\Destination::FILE);

        // 5. Buscar o crear plantilla default
        $plantilla = PlantillaDocumento::find()
            ->where(['nombre' => 'Constancia Default'])
            ->one();

        if (!$plantilla) {
            $plantilla = new PlantillaDocumento();
            $plantilla->nombre = 'Constancia Default';
            $plantilla->tipo = PlantillaDocumento::TIPO_CONSTANCIA;
            $plantilla->contenido = 'Contenido básico de constancia';
            $plantilla->activo = 1;
            
            if (!$plantilla->save()) {
                throw new \Exception('Error al crear plantilla: ' . json_encode($plantilla->errors));
            }
        }

        // 6. Registrar documento en base de datos
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
            // Eliminar archivo PDF si falla guardar en BD
            if (file_exists($rutaCompleta)) {
                unlink($rutaCompleta);
            }
            throw new \Exception('Error al guardar documento: ' . json_encode($documento->errors));
        }

        // 7. Retornar respuesta exitosa
        return [
            'success' => true,
            'pdfUrl' => Url::to($rutaArchivo, true),
            'pdfViewUrl' => Url::to(['documento-generado/view-pdf', 'id' => $documento->id], true),
            'downloadUrl' => Url::to(['documento-generado/download', 'id' => $documento->id], true),
            'documentoId' => $documento->id,
            'historialUrl' => Url::to(['documento-generado/ver-historia', 'alumno_id' => $alumno->id])
        ];
        
    } catch (\Exception $e) {
        Yii::error("Error al generar PDF: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        return [
            'success' => false,
            'error' => 'Error al generar documento: ' . $e->getMessage(),
            'technical' => YII_DEBUG ? $e->getTraceAsString() : null
        ];
    }
}
    protected function findModel($id)
    {
        if (($model = Alumno::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('La página solicitada no existe.');
    }
    public function actionBuscar()
{
    $model = new Alumno();
    
    if ($model->load(Yii::$app->request->get()) && !empty($model->matricula)) {
        $alumno = Alumno::find()
            ->where(['matricula' => trim($model->matricula)])
            ->one();
        
        if ($alumno) {
            // Redirige directamente a la vista del alumno si se encuentra
            return $this->redirect(['view', 'id' => $alumno->id]);
        }
        
        Yii::$app->session->setFlash('error', 'No se encontró alumno con matrícula: ' . $model->matricula);
        return $this->redirect(['site/index']);
    }
    
    // Si no se envió matrícula o está vacía
    Yii::$app->session->setFlash('warning', 'Ingrese una matrícula válida');
    return $this->redirect(['site/index']);
}

public function actionValidar($id)
{
    $model = $this->findModel($id);
    $requisitos = Requisito::find()
        ->where(['programa_id' => $model->programa_id])
        ->all();
    
    if (Yii::$app->request->isPost) {
        $post = Yii::$app->request->post();
        $requisitosValidados = $post['requisitos'] ?? [];
        $comentarios = $post['comentarios'] ?? [];
        
        // Procesar cada requisito
        foreach ($requisitos as $requisito) {
            $avance = AvanceAlumno::find()
                ->where(['alumno_id' => $id, 'requisito_id' => $requisito->id])
                ->one();
            
            if (!$avance) {
                $avance = new AvanceAlumno();
                $avance->alumno_id = $id;
                $avance->requisito_id = $requisito->id;
            }
            
            $avance->completado = in_array($requisito->id, $requisitosValidados) ? 1 : 0;
            $avance->fecha_completado = $avance->completado ? date('Y-m-d H:i:s') : null;
            $avance->comentarios = $comentarios[$requisito->id] ?? null;
            $avance->validado_por = Yii::$app->user->id;
            
            $avance->save();
        }
        
        Yii::$app->session->setFlash('success', 'Requisitos actualizados correctamente');
        return $this->redirect(['view', 'id' => $id]);
    }
    
    return $this->render('validar', [
        'model' => $model,
        'requisitos' => $requisitos
    ]);
}

}