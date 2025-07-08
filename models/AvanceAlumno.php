<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "avancealumno".
 *
 * @property int $id
 * @property int $alumno_id
 * @property int $requisito_id
 * @property int $completado
 * @property string|null $fecha_completado
 * @property string|null $evidencia
 * @property string|null $comentarios
 * @property int|null $validado_por
 *
 * @property Alumno $alumno
 * @property Requisito $requisito
 */
class Avancealumno extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avancealumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_completado', 'evidencia', 'comentarios', 'validado_por'], 'default', 'value' => null],
            [['completado'], 'default', 'value' => 0],
            [['alumno_id', 'requisito_id'], 'required'],
            [['alumno_id', 'requisito_id', 'completado', 'validado_por'], 'integer'],
            [['fecha_completado'], 'safe'],
            [['comentarios'], 'string'],
            [['evidencia'], 'string', 'max' => 255],
            [['alumno_id', 'requisito_id'], 'unique', 'targetAttribute' => ['alumno_id', 'requisito_id']],
            [['alumno_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::class, 'targetAttribute' => ['alumno_id' => 'id']],
            [['requisito_id'], 'exist', 'skipOnError' => true, 'targetClass' => Requisito::class, 'targetAttribute' => ['requisito_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alumno_id' => Yii::t('app', 'Alumno ID'),
            'requisito_id' => Yii::t('app', 'Requisito ID'),
            'completado' => Yii::t('app', 'Completado'),
            'fecha_completado' => Yii::t('app', 'Fecha Completado'),
            'evidencia' => Yii::t('app', 'Evidencia'),
            'comentarios' => Yii::t('app', 'Comentarios'),
            'validado_por' => Yii::t('app', 'Validado Por'),
        ];
    }

    /**
     * Gets query for [[Alumno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno()
    {
        return $this->hasOne(Alumno::class, ['id' => 'alumno_id']);
    }

    /**
     * Gets query for [[Requisito]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisito()
    {
        return $this->hasOne(Requisito::class, ['id' => 'requisito_id']);
    }

}
