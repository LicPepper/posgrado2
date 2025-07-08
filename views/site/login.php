<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>
<style>
    .login-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 2rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .login-header {
        color: #003366; /* Azul marino del Tec */
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .login-btn {
        background-color: #003366; /* Azul marino del Tec */
        border: none;
        width: 100%;
        padding: 10px;
    }
    .login-btn:hover {
        background-color: #004080; /* Azul un poco más claro */
    }
    .form-control:focus {
        border-color: #003366;
        box-shadow: 0 0 0 0.25rem rgba(0, 51, 102, 0.25);
    }
</style>

<div class="login-container">
    <h1 class="login-header"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control mb-3']) ?>

        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control mb-3']) ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group mt-4">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary login-btn', 'name' => 'login-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>