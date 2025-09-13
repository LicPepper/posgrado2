<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Alert;

/** @var $model app\models\Alumno */
/** @var $searchPerformed bool */
/** @var $totalAlumnos int */
/** @var $totalDocumentos int */
/** @var $totalRequisitos int */
?>

<div class="site-index">
    <!-- Banner superior -->
    <div class="jumbotron bg-primary text-white py-4 mb-4 rounded">
        <h1 class="display-4">Sistema de Documentos de Posgrado</h1>
        <p class="lead">Instituto Tecnológico de Villahermosa</p>
    </div>

    <!-- Barra de búsqueda -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h3 class="text-center mb-4"><i class="fas fa-search mr-2"></i>Buscar Alumno</h3>
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['/alumno/buscar'],
            ]); ?>

            <div class="input-group mb-3">
                <?= $form->field($model, 'matricula', [
                    'options' => ['class' => 'form-group flex-grow-1 mb-0'],
                    'inputOptions' => [
                        'placeholder' => 'Ingrese la matrícula del alumno',
                        'class' => 'form-control form-control-lg',
                        'autofocus' => true
                    ],
                    'template' => '{input}',
                ])->label(false) ?>
                
                <div class="input-group-append">
                    <?= Html::submitButton('<i class="fas fa-search mr-2"></i> Buscar', [
                        'class' => 'btn btn-primary btn-lg'
                    ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>>

    <!-- Mensajes flash -->
    <?php
    $flashMessages = Yii::$app->session->getAllFlashes();
    foreach ($flashMessages as $key => $message) {
        echo Alert::widget([
            'options' => ['class' => 'alert-' . $key . ' mt-3'],
            'body' => $message
        ]);
    }
    ?>

    <!-- Contenido principal -->
    <div class="row mt-4">
        <!-- Estadísticas -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-chart-bar mr-2"></i>Estadísticas del Sistema
                    </h4>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Alumnos registrados
                            <span class="badge bg-primary rounded-pill"><?= $totalAlumnos ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Documentos generados
                            <span class="badge bg-primary rounded-pill"><?= $totalDocumentos ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Requisitos completados
                            <span class="badge bg-primary rounded-pill"><?= $totalRequisitos ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instrucciones -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-info-circle mr-2"></i>¿Cómo generar documentos?
                    </h4>
                </div>
                <div class="card-body">
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item">Busca al alumno por su matrícula</li>
                        <li class="list-group-item">Verifica que cumpla con los requisitos</li>
                        <li class="list-group-item">Selecciona el tipo de documento a generar</li>
                        <li class="list-group-item">Revisa y descarga el documento PDF</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.site-index {
    padding: 20px 0;
}

.jumbotron {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    padding: 2rem 1rem;
}

.card {
    border: none;
    border-radius: 10px;
}

.list-group-item {
    border-left: none;
    border-right: none;
    padding: 1rem 1.25rem;
}

.bg-primary {
    background-color: #2c3e50 !important;
}
</style>