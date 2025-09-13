<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        return "¡TEST FUNCIONA! User ID: " . Yii::$app->user->id;
    }
    
    public function actionProfile($id)
    {
        return "Perfil TEST - ID: " . $id . " - User actual: " . Yii::$app->user->id;
    }
    
    public function actionErrorTest()
    {
        // Forzar un error para ver los logs
        throw new \Exception("Este es un error de prueba");
    }
}