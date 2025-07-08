<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documentogenerado".
 *
 * @property int $id
 * @property int $alumno_id
 * @property int $plantilla_id
 * @property string $ruta_archivo
 * @property string $hash_verificacion
 * @property string $fecha_generacion
 * @property int|null $generado_por
 * @property int $version
 * @property string $estado
 * @property string|null $comentarios
 *
 * @property Alumno $alumno
 * @property Plantilladocumento $plantilla
 */
class DocumentoGenerado extends \yii\db\ActiveRecord
{
    /**
     * ENUM field values
     */
    const ESTADO_GENERADO = 'Generado';
    const ESTADO_VALIDADO = 'Validado';
    const ESTADO_RECHAZADO = 'Rechazado';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documentoGenerado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['generado_por', 'comentarios'], 'default', 'value' => null],
            [['version'], 'default', 'value' => 1],
            [['estado'], 'default', 'value' => 'Generado'],
            [['alumno_id', 'plantilla_id', 'ruta_archivo', 'hash_verificacion'], 'required'],
            [['alumno_id', 'plantilla_id', 'generado_por', 'version'], 'integer'],
            [['fecha_generacion'], 'safe'],
            [['estado', 'comentarios'], 'string'],
            [['ruta_archivo'], 'string', 'max' => 255],
            [['hash_verificacion'], 'string', 'max' => 64],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            [['alumno_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::class, 'targetAttribute' => ['alumno_id' => 'id']],
            [['plantilla_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlantillaDocumento::className(), 'targetAttribute' => ['plantilla_id' => 'id']],
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
            'plantilla_id' => Yii::t('app', 'Plantilla ID'),
            'ruta_archivo' => Yii::t('app', 'Ruta Archivo'),
            'hash_verificacion' => Yii::t('app', 'Hash Verificacion'),
            'fecha_generacion' => Yii::t('app', 'Fecha Generacion'),
            'generado_por' => Yii::t('app', 'Generado Por'),
            'version' => Yii::t('app', 'Version'),
            'estado' => Yii::t('app', 'Estado'),
            'comentarios' => Yii::t('app', 'Comentarios'),
        ];
    }

    /**
     * Gets query for [[Alumno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno() {
        return $this->hasOne(Alumno::class, ['id' => 'alumno_id']);
    }

    public function getPlantilla()
    {
        return $this->hasOne(Plantilladocumento::class, ['id' => 'plantilla_id']);
    }

    /**
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_GENERADO => Yii::t('app', 'Generado'),
            self::ESTADO_VALIDADO => Yii::t('app', 'Validado'),
            self::ESTADO_RECHAZADO => Yii::t('app', 'Rechazado'),
        ];
    }

    /**
     * @return string HTML label for current estado
     */
    public function getEstadoLabel()
    {
        $estados = [
            self::ESTADO_GENERADO => '<span class="label label-primary">Generado</span>',
            self::ESTADO_VALIDADO => '<span class="label label-success">Validado</span>',
            self::ESTADO_RECHAZADO => '<span class="label label-danger">Rechazado</span>',
        ];
        
        return $estados[$this->estado] ?? $this->estado;
    }

    /**
     * @return string Display label for current estado
     */
    public function displayEstado()
    {
        return self::optsEstado()[$this->estado] ?? $this->estado;
    }

    /**
     * @return bool
     */
    public function isEstadoGenerado()
    {
        return $this->estado === self::ESTADO_GENERADO;
    }

    public function setEstadoToGenerado()
    {
        $this->estado = self::ESTADO_GENERADO;
    }

    /**
     * @return bool
     */
    public function isEstadoValidado()
    {
        return $this->estado === self::ESTADO_VALIDADO;
    }

    public function setEstadoToValidado()
    {
        $this->estado = self::ESTADO_VALIDADO;
    }

    /**
     * @return bool
     */
    public function isEstadoRechazado()
    {
        return $this->estado === self::ESTADO_RECHAZADO;
    }

    public function setEstadoToRechazado()
    {
        $this->estado = self::ESTADO_RECHAZADO;
    }

    public function actions()
    {
        return [
            'download' => [
                'class' => 'yii\web\DownloadAction',
                'modelName' => 'DocumentoGenerado',
                'fileAttribute' => 'ruta_archivo',
                'basePath' => '@webroot/documentos',
            ],
        ];
    }
}