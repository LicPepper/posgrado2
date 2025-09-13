<?php
// generar_hash.php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/config/web.php';
new yii\web\Application($config);

$password = '12345';
$hash = Yii::$app->security->generatePasswordHash($password);

echo "Contraseña: " . $password . "\n";
echo "Hash generado: " . $hash . "\n";

// Verificar que el hash es válido
$isValid = Yii::$app->security->validatePassword($password, $hash);
echo "Hash válido: " . ($isValid ? 'SÍ' : 'NO') . "\n";
?>