<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Programa;

/** @var yii\web\View $this */
/** @var app\models\Alumno $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="alumno-form">

    <?php $form = ActiveForm::begin([
        'id' => 'alumno-form',
        'enableClientValidation' => true,
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'required' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'apellido_paterno')->textInput(['maxlength' => true, 'required' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'apellido_materno')->textInput(['maxlength' => true, 'required' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'matricula')->textInput(['maxlength' => true, 'required' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'programa_id')->dropDownList(
                ArrayHelper::map(Programa::find()->all(), 'id', 'nombre'),
                ['prompt' => 'Seleccione un programa...', 'class' => 'form-control', 'required' => true]
            )->label('Programa') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'required' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'telefono')->textInput(['maxlength' => true, 'required' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'activo')->dropDownList(
                [1 => 'Sí', 0 => 'No'],
                ['prompt' => 'Seleccione una opción...', 'class' => 'form-control', 'required' => true]
            )->label('Activo') ?>
        </div>
    </div>

    <?= $form->field($model, 'fecha_creacion')->textInput()->label(false) ?>

    <div class="form-group mt-4">
        <?= Html::submitButton('<i class="fas fa-save"></i> ' . Yii::t('app', 'Guardar'), [
            'class' => 'btn btn-success',
            'onclick' => 'return validateForm()'
        ]) ?>
        <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
function validateForm() {
    var form = document.getElementById('alumno-form');
    var requiredFields = form.querySelectorAll('[required]');
    var missingFields = [];
    
    // Verificar cada campo obligatorio
    requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
            // Obtener el nombre del campo desde la etiqueta
            var label = form.querySelector('label[for="' + field.id + '"]');
            var fieldName = label ? label.textContent.trim().replace('*', '').trim() : field.name;
            missingFields.push(fieldName);
            
            // Resaltar campo vacío
            field.classList.add('is-invalid');
            field.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        }
    });
    
    // Si hay campos faltantes, mostrar alerta
    if (missingFields.length > 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos obligatorios',
            html: 'Por favor, complete los siguientes campos obligatorios:<br><br>' + 
                  missingFields.map(function(field) {
                      return '• ' + field;
                  }).join('<br>'),
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Entendido'
        });
        
        // Hacer scroll al primer campo faltante
        var firstMissingField = form.querySelector('[required]:invalid');
        if (firstMissingField) {
            firstMissingField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstMissingField.focus();
        }
        
        return false;
    }
    
    return true;
}

// Validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('alumno-form');
    var requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(function(field) {
        field.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>

<style>
.is-invalid {
    border-color: #dc3545 !important;
}
.field-alumno-fecha_creacion {
    display: none;
}
</style>

<?php
// Incluir SweetAlert2 para las alertas bonitas
$this->registerJsFile('https://cdn.jsdelivr.net/npm/sweetalert2@11', ['position' => \yii\web\View::POS_HEAD]);
?>