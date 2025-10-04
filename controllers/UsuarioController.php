<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use app\models\User;

/**
 * UsuarioController implementa las acciones para el perfil de usuario
 */
class UsuarioController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios autenticados
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Muestra el perfil del usuario
     * @param int $id ID del usuario
     * @return string
     * @throws NotFoundHttpException si el modelo no se encuentra
     */
    public function actionView($id)
    {
        // Verifica que el usuario solo pueda ver su propio perfil
        if ($id != Yii::$app->user->id) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a este perfil');
        }

        // Usa el modelo User para la autenticación
        $user = \app\models\User::findIdentity($id);
        
        if (!$user) {
            throw new NotFoundHttpException('El usuario no existe');
        }
        
        return $this->render('view', [
            'model' => $user,
        ]);
    }

    /**
     * Actualiza la configuración del usuario
     * @param int $id ID del usuario
     * @return string
     * @throws NotFoundHttpException si el modelo no se encuentra
     */
    public function actionUpdate($id)
{
    // Verifica que el usuario solo pueda editar su propio perfil
    if ($id != Yii::$app->user->id) {
        throw new ForbiddenHttpException('No tienes permiso para editar este perfil');
    }

    $model = User::findIdentity($id);
    
    if (!$model) {
        throw new NotFoundHttpException('El usuario no existe');
    }

    // Guardar la contraseña actual para comparar después
    $currentPassword = $model->password_hash;

    if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
        // Si se proporcionó una nueva contraseña, hashearla
        if (!empty($model->password_hash)) {
            $model->setPassword($model->password_hash);
        } else {
            // Si está vacía, mantener la contraseña actual
            $model->password_hash = $currentPassword;
        }
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Tus cambios han sido guardados exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    // Limpiar el campo de contraseña para que no muestre el hash
    $model->password_hash = '';

    return $this->render('update', [
        'model' => $model,
    ]);
}
    /**
     * Elimina un usuario (solo administradores)
     */
    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;
        
        // Solo administradores pueden eliminar usuarios
        if (!$user || !$user->puede('eliminar')) {
            throw new ForbiddenHttpException('No tienes permisos para eliminar usuarios.');
        }

        // No permitir que un usuario se elimine a sí mismo
        if ($id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'No puedes eliminar tu propio usuario.');
            return $this->redirect(['index']);
        }

        $model = \app\models\User::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('El usuario no existe');
        }

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Usuario eliminado correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Error al eliminar el usuario.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Lista todos los usuarios (solo para administradores/moderadores)
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        
        // Verificar permisos para ver la lista de usuarios
        if (!$user || !$user->puede('ver')) {
            throw new ForbiddenHttpException('No tienes permisos para ver la lista de usuarios.');
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \app\models\User::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'nombre' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Crear nuevo usuario (solo administradores)
     */
    public function actionCreate()
{
    $user = Yii::$app->user->identity;
    
    if (!$user || !$user->puede('crear')) {
        throw new ForbiddenHttpException('No tienes permisos para crear usuarios.');
    }

    $model = new User();
    $model->scenario = 'create';

    if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
        // VERIFICAR SI LA CONTRASEÑA NO ESTÁ VACÍA ANTES DE ENCRIPTAR
        if (!empty($model->password_hash)) {
            $model->setPassword($model->password_hash);
        } else {
            // Si está vacía, mostrar error o asignar una contraseña por defecto
            $model->addError('password_hash', 'La contraseña es obligatoria');
            return $this->render('create', ['model' => $model]);
        }
        
        $model->activo = 1;
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Usuario creado exitosamente.');
            // Redirigir al listado de usuarios en lugar de a la vista del usuario
            return $this->redirect(['index']);
        }
    }

    return $this->render('create', [
        'model' => $model,
    ]);
}
}