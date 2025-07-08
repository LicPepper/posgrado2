<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\ActiveForm;

/* @var $model app\models\Alumno */
/* @var $requisitos app\models\Requisito[] */
?>

<div class="card border-primary">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">
            <i class="fas fa-check-circle"></i> Validar Requisitos: <?= Html::encode($model->nombreCompleto) ?>
        </h3>
    </div>
    
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'validar-requisitos-form',
            'enableClientValidation' => true,
        ]); ?>
        
        <input type="hidden" name="alumno_id" value="<?= $model->id ?>">
        
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">Validar</th>
                        <th width="45%">Requisito</th>
                        <th width="50%">Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requisitos as $requisito): 
                        $avance = $model->getAvanceAlumnos()
                            ->where(['requisito_id' => $requisito->id])
                            ->one();
                    ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" 
                                    name="requisitos[]" 
                                    value="<?= $requisito->id ?>"
                                    <?= ($avance && $avance->completado) ? 'checked' : '' ?>
                                    class="form-check-input">
                            </td>
                            <td>
                                <?= Html::encode($requisito->nombre) ?>
                                <?php if ($requisito->obligatorio): ?>
                                    <span class="badge bg-danger">Obligatorio</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <input type="text" 
                                    name="comentarios[<?= $requisito->id ?>]" 
                                    value="<?= $avance ? Html::encode($avance->comentarios) : '' ?>"
                                    class="form-control" 
                                    placeholder="Observaciones...">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="form-group mt-4">
            <?= Html::submitButton('<i class="fas fa-save"></i> Guardar Validación', [
                'class' => 'btn btn-success btn-lg',
            ]) ?>
            
            <?= Html::a('<i class="fas fa-arrow-left"></i> Cancelar', ['view', 'id' => $model->id], [
                'class' => 'btn btn-secondary btn-lg',
            ]) ?>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>
</div>

<style>
.requisito-obligatorio {
    font-weight: bold;
}
</style>