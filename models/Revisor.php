<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "revisor".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $cargo
 * @property int|null $activo
 */
class Revisor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'revisor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cargo'], 'default', 'value' => 'CATEDRÁTICO DEL INSTITUTO TECNOLÓGICO DE VILLAHERMOSA'],
            [['activo'], 'default', 'value' => 1],
            [['nombre'], 'required'],
            [['activo'], 'integer'],
            [['nombre', 'cargo'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'cargo' => Yii::t('app', 'Cargo'),
            'activo' => Yii::t('app', 'Activo'),
        ];
    }

}
