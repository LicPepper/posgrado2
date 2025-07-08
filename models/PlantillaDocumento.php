<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantilladocumento".
 *
 * @property int $id
 * @property string $nombre
 * @property int|null $programa_id
 * @property string $tipo
 * @property string $contenido
 * @property string|null $campos_dinamicos
 * @property int $activo
 *
 * @property Documentogenerado[] $documentogenerados
 * @property Programa $programa
 */
class Plantilladocumento extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const TIPO_LIBERACION_INGLES = 'Liberación Inglés';
    const TIPO_ESTANCIA = 'Estancia';
    const TIPO_LIBERACION_TESIS = 'Liberación Tesis';
    const TIPO_CONSTANCIA = 'Constancia';
    const TIPO_KARDEX = 'Kardex';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantilladocumento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['programa_id', 'campos_dinamicos'], 'default', 'value' => null],
            [['activo'], 'default', 'value' => 1],
            [['nombre', 'tipo', 'contenido'], 'required'],
            [['programa_id', 'activo'], 'integer'],
            [['tipo', 'contenido'], 'string'],
            [['campos_dinamicos'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
            ['tipo', 'in', 'range' => array_keys(self::optsTipo())],
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
            'nombre' => Yii::t('app', 'Nombre'),
            'programa_id' => Yii::t('app', 'Programa ID'),
            'tipo' => Yii::t('app', 'Tipo'),
            'contenido' => Yii::t('app', 'Contenido'),
            'campos_dinamicos' => Yii::t('app', 'Campos Dinamicos'),
            'activo' => Yii::t('app', 'Activo'),
        ];
    }

    /**
     * Gets query for [[Documentogenerados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentogenerados()
    {
        return $this->hasMany(Documentogenerado::class, ['plantilla_id' => 'id']);
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


    /**
     * column tipo ENUM value labels
     * @return string[]
     */
    public static function optsTipo()
{
    return [
        self::TIPO_LIBERACION_INGLES => Yii::t('app', 'Liberación de Inglés'),
        self::TIPO_ESTANCIA => Yii::t('app', 'Carta de Estancia'),
        self::TIPO_LIBERACION_TESIS => Yii::t('app', 'Liberación de Tesis'),
        self::TIPO_CONSTANCIA => Yii::t('app', 'Constancia'),
        self::TIPO_KARDEX => Yii::t('app', 'Kardex')
    ];
}

    /**
     * @return string
     */
    public function displayTipo()
    {
        return self::optsTipo()[$this->tipo];
    }

    /**
     * @return bool
     */
    public function isTipoConstancia()
    {
        return $this->tipo === self::TIPO_CONSTANCIA;
    }

    public function setTipoToConstancia()
    {
        $this->tipo = self::TIPO_CONSTANCIA;
    }

    /**
     * @return bool
     */
    public function isTipoCartaLiberacion()
    {
        return $this->tipo === self::TIPO_CARTA_LIBERACION;
    }

    public function setTipoToCartaLiberacion()
    {
        $this->tipo = self::TIPO_CARTA_LIBERACION;
    }

    /**
     * @return bool
     */
    public function isTipoKardex()
    {
        return $this->tipo === self::TIPO_KARDEX;
    }

    public function setTipoToKardex()
    {
        $this->tipo = self::TIPO_KARDEX;
    }

    /**
     * @return bool
     */
    public function isTipoOtro()
    {
        return $this->tipo === self::TIPO_OTRO;
    }

    public function setTipoToOtro()
    {
        $this->tipo = self::TIPO_OTRO;
    }
}
