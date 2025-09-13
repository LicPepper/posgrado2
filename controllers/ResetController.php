<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;

class ResetController extends Controller
{
    public function actionPasswords()
    {
        // Solo permitir en desarrollo
        if (!YII_DEBUG) {
            die('Solo disponible en modo desarrollo');
        }

        $users = User::find()->all();
        
        foreach ($users as $user) {
            $user->setPassword('password123'); // Contraseña temporal
            if ($user->save()) {
                echo "Contraseña resetada para: " . $user->username . "<br>";
            } else {
                echo "Error con: " . $user->username . "<br>";
            }
        }
        
        die('Contraseñas reseteadas. Usa: username: admin, password: password123');
    }
}