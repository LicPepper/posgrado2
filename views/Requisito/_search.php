<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Programa;
use app\models\Requisito;

/** @var yii\web\View $this */
/** @var app\models\Requisito $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $programas */
/** @var array $tiposDocumentos */

// Obtener tipos de documentos si no está definida la variable
if (!isset($tiposDocumentos)) {
    $tiposDocumentos = Requisito::getTiposDocumentos();
}
?>

<div class="requisito-form">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><?= isset($model->isNewRecord) && $model->isNewRecord ? 'Crear Nuevo Requisito' : 'Actualizar Requisito' ?></h3>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'requisito-form',
                'enableClientValidation' => true,
            ]); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'tipo_documento')->dropDownList(
                        $tiposDocumentos,
                        [
                            'prompt' => 'Seleccione el tipo de documento',
                            'class' => 'form-control',
                            'required' => true
                        ]
                    ) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'programa_id')->dropDownList(
                        ArrayHelper::map(Programa::find()->all(), 'id', 'nombre'),
                        [
                            'prompt' => 'Seleccione un programa...', 
                            'class' => 'form-control'
                        ]
                    )->label('Programa (opcional)') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'nombre')->textInput([
                        'maxlength' => true, 
                        'required' => true,
                        'placeholder' => 'Ingrese el nombre del requisito'
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'orden')->textInput([
                        'type' => 'number',
                        'min' => 1,
                        'required' => true,
                        'placeholder' => '1'
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'obligatorio')->dropDownList([
                        1 => 'Sí',
                        0 => 'No'
                    ], [
                        'class' => 'form-control',
                        'required' => true
                    ]) ?>
                </div>
            </div>

            <?= $form->field($model, 'descripcion')->textarea([
                'rows' => 3,
                'placeholder' => 'Descripción detallada del requisito (opcional)'
            ]) ?>

            <div class="form-group mt-4">
                <?= Html::submitButton('<i class="fas fa-save"></i> ' . Yii::t('app', 'Guardar'), [
                    'class' => 'btn btn-success',
                    'onclick' => 'return validateRequisitoForm()'
                ]) ?>
                <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<script>
function validateRequisitoForm() {
    var form = document.getElementById('requisito-form');
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
    var form = document.getElementById('requisito-form');
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
</style>

<?php
// Incluir SweetAlert2 para las alertas bonitas
$this->registerJsFile('https://cdn.jsdelivr.net/npm/sweetalert2@11', ['position' => \yii\web\View::POS_HEAD]);
?>