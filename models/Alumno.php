<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alumno".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $matricula
 * @property int $programa_id
 * @property string $email
 * @property string|null $telefono
 * @property int $activo
 * @property string $fecha_creacion
 *
 * @property Avancealumno[] $avancealumnos
 * @property Documentogenerado[] $documentogenerados
 * @property Requisito[] $requisitos
 * @property RevisorTesis[] $revisorTesis
 * @property Revisor[] $revisores
 */
class Alumno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telefono'], 'default', 'value' => null],
            [['activo'], 'default', 'value' => 1],
            [['nombre', 'apellido_paterno', 'apellido_materno', 'matricula', 'programa_id', 'email'], 'required'],
            [['programa_id', 'activo'], 'integer'],
            [['fecha_creacion'], 'safe'],
            [['nombre', 'email'], 'string', 'max' => 100],
            [['apellido_paterno', 'apellido_materno'], 'string', 'max' => 50],
            [['matricula'], 'string', 'max' => 20],
            [['telefono'], 'string', 'max' => 15],
            [['matricula'], 'unique'],
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
            'apellido_paterno' => Yii::t('app', 'Apellido Paterno'),
            'apellido_materno' => Yii::t('app', 'Apellido Materno'),
            'matricula' => Yii::t('app', 'Matricula'),
            'programa_id' => Yii::t('app', 'Programa ID'),
            'email' => Yii::t('app', 'Email'),
            'telefono' => Yii::t('app', 'Telefono'),
            'activo' => Yii::t('app', 'Activo'),
            'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
        ];
    }

    /**
     * Gets query for [[Avancealumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvanceAlumnos()
    {
        return $this->hasMany(AvanceAlumno::class, ['alumno_id' => 'id']);
    }

    /**
     * Gets query for [[Documentogenerados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentoGenerados()
    {
        return $this->hasMany(DocumentoGenerado::class, ['alumno_id' => 'id']);
    }

    /**
     * Gets query for [[Requisitos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisitos()
    {
        return $this->hasMany(Requisito::class, ['id' => 'requisito_id'])->viaTable('avancealumno', ['alumno_id' => 'id']);
    }

    /**
     * Gets query for [[RevisorTesis]].
     *
     * @return \yii\db\ActiveQuery
     */
    // Relación con RevisorTesis
public function getRevisorTesis()
{
    return $this->hasMany(RevisorTesis::class, ['alumno_id' => 'id']);
}

// Relación con Revisores (a través de RevisorTesis)
public function getRevisores()
{
    return $this->hasMany(Revisor::class, ['id' => 'revisor_id'])
        ->via('revisorTesis');
}

    public function getNombreCompleto()
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno);
    }

    public function getPrograma()
    {
        return $this->hasOne(Programa::className(), ['id' => 'programa_id']);
    }
}