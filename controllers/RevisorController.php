<?php
namespace app\controllers;

use Yii;
use app\models\Revisor;
use app\models\RevisorSearch;
use yii\web\Controller;
use yii\data\ActiveDataProvider; 
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class RevisorController extends Controller
{

    /**
     * Verifica los permisos del usuario
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
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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

    public function actionIndex($tipo = null)
    {
        $searchModel = new RevisorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if ($tipo) {
            $dataProvider->query->andWhere(['tipo_documento' => $tipo]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tipoDocumento' => $tipo,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Revisor(); // CORRECCIÓN: Cambiado de Requisito a Revisor

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Revisor creado exitosamente.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Revisor actualizado correctamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Revisor eliminado correctamente.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Revisor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El revisor solicitado no existe.');
    }
}