<?php
// create_valid_user.php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/config/web.php';
new yii\web\Application($config);

// Crear usuario con contraseña hasheada CORRECTAMENTE
$user = new \app\models\User();
$user->username = 'gonzalo';
$user->nombre = 'Administrador del Sistema';
$user->email = 'admin@itvh.edu.mx';
$user->rol = 'Administrador';
$user->activo = 1;

// ESTA es la forma CORRECTA de establecer la contraseña
$user->setPassword('12345');

if ($user->save()) {
    echo "✅ Usuario creado EXITOSAMENTE\n";
    echo "Username: gonzalo\n";
    echo "Password: 12345\n";
    echo "Hash generado: " . $user->password_hash . "\n";
    
    // Verificación EXTRA para asegurarnos
    $testUser = \app\models\User::findByUsername('gonzalo');
    if ($testUser) {
        echo "✅ Usuario encontrado en BD\n";
        $isValid = Yii::$app->security->validatePassword('12345', $testUser->password_hash);
        echo "✅ Validación de contraseña: " . ($isValid ? 'EXITOSA' : 'FALLIDA') . "\n";
        
        if ($isValid) {
            echo "🎉 ¡Todo funciona! Puedes iniciar sesión con:\n";
            echo "Usuario: gonzalo\n";
            echo "Contraseña: 12345\n";
        } else {
            echo "❌ El hash NO es válido. Hash en BD: " . $testUser->password_hash . "\n";
        }
    }
} else {
    echo "❌ Error al crear usuario:\n";
    print_r($user->errors);
}
?>