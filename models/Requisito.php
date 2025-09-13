<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requisito".
 *
 * @property int $id
 * @property int|null $programa_id
 * @property string $tipo_documento
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
            [['programa_id', 'obligatorio', 'orden'], 'integer'],
            
            [['descripcion'], 'string'],
            [['tipo_documento'], 'string', 'max' => 50],
            [['tipo_documento'], 'in', 'range' => array_keys(self::getTiposDocumentos())],
            [['obligatorio'], 'default', 'value' => 1],
            [['orden'], 'integer', 'min' => 1],
            [['programa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programa::class, 'targetAttribute' => ['programa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'programa_id' => 'Programa',
            'tipo_documento' => 'Tipo de Documento',
            'nombre' => 'Nombre del Requisito',
            'descripcion' => 'Descripción',
            'obligatorio' => 'Obligatorio',
            'orden' => 'Orden',
        ];
    }

    /**
     * Gets query for [[Alumnos]].
     */
    public function getAlumnos()
    {
        return $this->hasMany(Alumno::class, ['id' => 'alumno_id'])->viaTable('avancealumno', ['requisito_id' => 'id']);
    }

    /**
     * Gets query for [[Avancealumnos]].
     */
    public function getAvancealumnos()
    {
        return $this->hasMany(Avancealumno::class, ['requisito_id' => 'id']);
    }

    /**
     * Gets query for [[Programa]].
     */
    public function getPrograma()
    {
        return $this->hasOne(Programa::class, ['id' => 'programa_id']);
    }

    /**
     * Obtiene los tipos de documentos disponibles
     */
    public static function getTiposDocumentos()
    {
        return [
            'LiberacionIngles' => 'Liberación de Inglés',
            'LiberacionTesis' => 'Liberación de Tesis',
            'Estancia' => 'Carta de Estancia',
            'Constancia' => 'Constancia General',
            'Kardex' => 'Kardex',
            
        ];
    }

    /**
     * Obtiene los requisitos para un tipo de documento específico
     */
    public static function getRequisitosPorTipo($tipo)
    {
        return self::find()
            ->where(['tipo_documento' => $tipo])
            ->orderBy(['orden' => SORT_ASC])
            ->all();
    }

    /**
     * Verifica si un alumno cumple con todos los requisitos para un documento
     */
    public static function verificarCumplimiento($alumnoId, $tipoDocumento)
    {
        $requisitos = self::getRequisitosPorTipo($tipoDocumento);
        
        foreach ($requisitos as $requisito) {
            $avance = Avancealumno::find()
                ->where(['alumno_id' => $alumnoId, 'requisito_id' => $requisito->id, 'completado' => 1])
                ->exists();
            
            if (!$avance) {
                return false;
            }
        }
        
        return true;
    }
}