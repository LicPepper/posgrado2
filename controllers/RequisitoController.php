<?php

namespace app\controllers;

use Yii;
use app\models\Requisito;
use app\models\RequisitoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 
use app\models\Programa;

/**
 * RequisitoController implements the CRUD actions for Requisito model.
 */
class RequisitoController extends Controller
{
    /**
     * @inheritDoc
     */
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
                        'roles' => ['@'], // Solo usuarios autenticados
                    ],
                ],
            ],
        ]
    );
}

    /**
     * Lists all Requisito models.
     *
     * @param string|null $tipo Filtro por tipo de documento
     * @return string
     */
    public function actionIndex($tipo = null)
{
    $searchModel = new RequisitoSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);
    
    // Filtrar por tipo de documento si se especificó
    if ($tipo) {
        $dataProvider->query->andWhere(['tipo_documento' => $tipo]);
        $searchModel->tipo_documento = $tipo;
    }

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'tipoDocumento' => $tipo,
    ]);
}

    /**
     * Displays a single Requisito model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Requisito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param string|null $tipo_documento Tipo de documento pre-seleccionado
     * @return string|\yii\web\Response
     */
    public function actionCreate($tipo_documento = null)
{
    $model = new Requisito();
    
    if ($tipo_documento) {
        $model->tipo_documento = $tipo_documento;
    }

    if ($this->request->isPost) {
        if ($model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Requisito creado exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
    } else {
        $model->loadDefaultValues();
    }

    $tiposDocumentos = Requisito::getTiposDocumentos();
    $programas = ArrayHelper::map(Programa::find()->all(), 'id', 'nombre');

    return $this->render('create', [
        'model' => $model,
        'tiposDocumentos' => $tiposDocumentos,
        'programas' => $programas
    ]);
}

public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Requisito actualizado exitosamente.');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    $tiposDocumentos = Requisito::getTiposDocumentos();
    $programas = ArrayHelper::map(Programa::find()->all(), 'id', 'nombre');

    return $this->render('update', [
        'model' => $model,
        'tiposDocumentos' => $tiposDocumentos,
        'programas' => $programas
    ]);
}

    /**
     * Deletes an existing Requisito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Requisito model based on its primary key value.
     * If the model is not found, a 404 exception will be thrown.
     * @param int $id ID
     * @return Requisito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Requisito::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
 * Vista de administración por tipo de documento
 */

}