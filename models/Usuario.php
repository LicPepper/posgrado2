<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $nombre
 * @property string $email
 * @property string $rol
 * @property int $activo
 */
class Usuario extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ROL_ADMINISTRADOR = 'Administrador';
    const ROL_COORDINADOR = 'Coordinador';
    const ROL_ASISTENTE = 'Asistente';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activo'], 'default', 'value' => 1],
            [['username', 'password_hash', 'nombre', 'email', 'rol'], 'required'],
            [['rol'], 'string'],
            [['activo'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['password_hash'], 'string', 'max' => 255],
            [['nombre', 'email'], 'string', 'max' => 100],
            ['rol', 'in', 'range' => array_keys(self::optsRol())],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'nombre' => Yii::t('app', 'Nombre'),
            'email' => Yii::t('app', 'Email'),
            'rol' => Yii::t('app', 'Rol'),
            'activo' => Yii::t('app', 'Activo'),
        ];
    }


    /**
     * column rol ENUM value labels
     * @return string[]
     */
    public static function optsRol()
    {
        return [
            self::ROL_ADMINISTRADOR => Yii::t('app', 'Administrador'),
            self::ROL_COORDINADOR => Yii::t('app', 'Coordinador'),
            self::ROL_ASISTENTE => Yii::t('app', 'Asistente'),
        ];
    }

    /**
     * @return string
     */
    public function displayRol()
    {
        return self::optsRol()[$this->rol];
    }

    /**
     * @return bool
     */
    public function isRolAdministrador()
    {
        return $this->rol === self::ROL_ADMINISTRADOR;
    }

    public function setRolToAdministrador()
    {
        $this->rol = self::ROL_ADMINISTRADOR;
    }

    /**
     * @return bool
     */
    public function isRolCoordinador()
    {
        return $this->rol === self::ROL_COORDINADOR;
    }

    public function setRolToCoordinador()
    {
        $this->rol = self::ROL_COORDINADOR;
    }

    /**
     * @return bool
     */
    public function isRolAsistente()
    {
        return $this->rol === self::ROL_ASISTENTE;
    }

    public function setRolToAsistente()
    {
        $this->rol = self::ROL_ASISTENTE;
    }
}
