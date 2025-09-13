<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Crear Revisor';
$this->params['breadcrumbs'][] = ['label' => 'Revisores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="revisor-create">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><?= Html::encode($this->title) ?></h3>
            <div class="float-right">
                <?= Html::a('<i class="fas fa-arrow-left"></i> Volver', ['index'], ['class' => 'btn btn-light btn-sm']) ?>
            </div>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'revisor-form',
                'enableClientValidation' => true,
            ]); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'nombre')->textInput([
                        'maxlength' => true, 
                        'required' => true,
                        'placeholder' => 'Ingrese el nombre completo del revisor'
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'cargo')->textInput([
                        'maxlength' => true,
                        'required' => true,
                        'value' => 'CATEDRÁTICO DEL INSTITUTO TECNOLÓGICO DE VILLAHERMOSA',
                        'placeholder' => 'Ingrese el cargo del revisor'
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'activo')->dropDownList(
                        [1 => 'Sí', 0 => 'No'],
                        [
                            'prompt' => 'Seleccione una opción...', 
                            'class' => 'form-control',
                            'required' => true
                        ]
                    )->label('¿Activo?') ?>
                </div>
            </div>

            <div class="form-group mt-4">
                <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', [
                    'class' => 'btn btn-success',
                    'onclick' => 'return validateRevisorForm()'
                ]) ?>
                <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
function validateRevisorForm() {
    var form = document.getElementById('revisor-form');
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
    var form = document.getElementById('revisor-form');
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