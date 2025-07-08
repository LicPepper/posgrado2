<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "programa".
 *
 * @property int $id
 * @property string $nombre
 * @property string $nivel
 * @property string|null $descripcion
 *
 * @property Plantilladocumento[] $plantilladocumentos
 * @property Requisito[] $requisitos
 */
class Programa extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const NIVEL_MAESTRIA = 'Maestría';
    const NIVEL_DOCTORADO = 'Doctorado';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'programa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'default', 'value' => null],
            [['nombre', 'nivel'], 'required'],
            [['nivel', 'descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 100],
            ['nivel', 'in', 'range' => array_keys(self::optsNivel())],
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
            'nivel' => Yii::t('app', 'Nivel'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    /**
     * Gets query for [[Plantilladocumentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlantilladocumentos()
    {
        return $this->hasMany(Plantilladocumento::class, ['programa_id' => 'id']);
    }

    /**
     * Gets query for [[Requisitos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisitos()
    {
        return $this->hasMany(Requisito::class, ['programa_id' => 'id']);
    }


    /**
     * column nivel ENUM value labels
     * @return string[]
     */
    public static function optsNivel()
    {
        return [
            self::NIVEL_MAESTRIA => Yii::t('app', 'Maestría'),
            self::NIVEL_DOCTORADO => Yii::t('app', 'Doctorado'),
        ];
    }

    /**
     * @return string
     */
    public function displayNivel()
    {
        return self::optsNivel()[$this->nivel];
    }

    /**
     * @return bool
     */
    public function isNivelMaestria()
    {
        return $this->nivel === self::NIVEL_MAESTRIA;
    }

    public function setNivelToMaestria()
    {
        $this->nivel = self::NIVEL_MAESTRIA;
    }

    /**
     * @return bool
     */
    public function isNivelDoctorado()
    {
        return $this->nivel === self::NIVEL_DOCTORADO;
    }

    public function setNivelToDoctorado()
    {
        $this->nivel = self::NIVEL_DOCTORADO;
    }
}
