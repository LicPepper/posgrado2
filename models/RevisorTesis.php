<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "revisor_tesis".
 *
 * @property int $id
 * @property int $alumno_id
 * @property int $revisor_id
 * @property string|null $fecha_asignacion
 */
class RevisorTesis extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'revisor_tesis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alumno_id', 'revisor_id'], 'required'],
            [['alumno_id', 'revisor_id'], 'integer'],
            [['fecha_asignacion'], 'safe'],
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
            'revisor_id' => Yii::t('app', 'Revisor ID'),
            'fecha_asignacion' => Yii::t('app', 'Fecha Asignacion'),
        ];
    }
    public function getRevisor()
{
    return $this->hasOne(Revisor::class, ['id' => 'revisor_id']);
}

}
