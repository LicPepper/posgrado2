<?php

namespace app\controllers;

use Yii;
use app\models\Programa;
use app\models\ProgramaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProgramaController implements the CRUD actions for Programa model.
 */
class ProgramaController extends Controller
{
    /**
     * @inheritDoc
     */

    protected function checkAccess($accion)
    {
        $user = Yii::$app->user->identity;
        
        if (!$user || !$user->puede($accion)) {
            throw new ForbiddenHttpException('No tienes permisos para realizar esta acción.');
        }
    }

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
            ]
        );
    }

    /**
     * Lists all Programa models.
     *
     * @return string
     */

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

    public function actionIndex()
    {
        $searchModel = new ProgramaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Programa model.
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
     * Creates a new Programa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Programa();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Programa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Programa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
{
    $model = $this->findModel($id);
    
    // Verificar si hay registros relacionados
    if ($model->getPlantilladocumentos()->count() > 0 || $model->getRequisitos()->count() > 0) {
        Yii::$app->session->setFlash('error', 'No se puede eliminar el programa porque tiene registros relacionados.');
        return $this->redirect(['index']);
    }
    
    try {
        $model->delete();
        Yii::$app->session->setFlash('success', 'Programa eliminado correctamente.');
    } catch (\Exception $e) {
        Yii::$app->session->setFlash('error', 'Error al eliminar el programa: ' . $e->getMessage());
    }

    return $this->redirect(['index']);
}

    /**
     * Finds the Programa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Programa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Programa::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
