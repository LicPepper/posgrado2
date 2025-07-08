<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="alumno-buscar">
    <div class="card border-0 shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-search mr-2"></i> Buscar Alumno por Matrícula
            </h3>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['buscar'],
                'options' => ['class' => 'mb-4']
            ]); ?>

            <div class="row align-items-end">
                <div class="col-md-8">
                    <?= $form->field($model, 'matricula', [
                        'inputOptions' => [
                            'placeholder' => 'Ejemplo: 2023001',
                            'class' => 'form-control form-control-lg',
                            'autofocus' => true
                        ],
                        'options' => ['class' => 'form-group mb-0']
                    ])->label(false) ?>
                </div>
                <div class="col-md-4">
                    <?= Html::submitButton('<i class="fas fa-search mr-2"></i> Buscar', [
                        'class' => 'btn btn-primary btn-lg btn-block'
                    ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
// Mostrar mensajes flash
$flashMessages = Yii::$app->session->getAllFlashes();
foreach ($flashMessages as $key => $message) {
    echo '<div class="alert alert-'.$key.' mt-3">'.$message.'</div>';
}
?>

<style>
.alumno-buscar {
    max-width: 800px;
    margin: 2rem auto;
    padding: 20px;
}

.card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-lg {
    padding: 0.5rem 1rem;
    font-size: 1.1rem;
}
</style>