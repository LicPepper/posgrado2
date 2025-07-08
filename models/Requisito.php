<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requisito".
 *
 * @property int $id
 * @property int $programa_id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $obligatorio
 * @property int $orden
 *
 * @property Alumno[] $alumnos
 * @property Avancealumno[] $avancealumnos
 * @property Programa $programa
 */
class Requisito extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requisito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'default', 'value' => null],
            [['obligatorio'], 'default', 'value' => 1],
            [['orden'], 'default', 'value' => 0],
            [['programa_id', 'nombre'], 'required'],
            [['programa_id', 'obligatorio', 'orden'], 'integer'],
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 100],
            [['programa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programa::class, 'targetAttribute' => ['programa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'programa_id' => Yii::t('app', 'Programa ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'obligatorio' => Yii::t('app', 'Obligatorio'),
            'orden' => Yii::t('app', 'Orden'),
        ];
    }

    /**
     * Gets query for [[Alumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnos()
    {
        return $this->hasMany(Alumno::class, ['id' => 'alumno_id'])->viaTable('avancealumno', ['requisito_id' => 'id']);
    }

    /**
     * Gets query for [[Avancealumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvancealumnos()
    {
        return $this->hasMany(Avancealumno::class, ['requisito_id' => 'id']);
    }

    /**
     * Gets query for [[Programa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrograma()
    {
        return $this->hasOne(Programa::class, ['id' => 'programa_id']);
    }

}
