<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
 * @property string $fecha_creacion
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * ENUM field values
     */
    const ROL_ADMINISTRADOR = 'Administrador';
    const ROL_MODERADOR = 'Moderador';
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
        [['username', 'password_hash', 'nombre', 'email', 'rol'], 'required'],
        [['password_hash'], 'required', 'on' => 'create'], 
        [['rol'], 'string'],
        [['activo'], 'integer'],
        [['username'], 'string', 'max' => 50],
        [['password_hash'], 'string', 'max' => 255],
        [['nombre', 'email'], 'string', 'max' => 100],
        [['username'], 'unique'],
    ];
}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuario',
            'password_hash' => 'Contraseña',
            'nombre' => 'Nombre',
            'email' => 'Email',
            'rol' => 'Rol',
            'activo' => 'Activo',
        ];
    }

    /**
     * column rol ENUM value labels
     * @return string[]
     */
    public static function optsRol()
    {
        return [
            self::ROL_ADMINISTRADOR => 'Administrador',
            self::ROL_MODERADOR => 'Moderador',
            self::ROL_ASISTENTE => 'Asistente',
        ];
    }

    /**
     * @return string
     */
    public function displayRol()
    {
        return self::optsRol()[$this->rol] ?? $this->rol;
    }

    /**
     * @return bool
     */
    public function isAdministrador()
    {
        return $this->rol === self::ROL_ADMINISTRADOR;
    }

    /**
     * @return bool
     */
    public function isModerador()
    {
        return $this->rol === self::ROL_MODERADOR;
    }

    /**
     * @return bool
     */
    public function isAsistente()
    {
        return $this->rol === self::ROL_ASISTENTE;
    }

    /**
     * Verifica permisos según el rol
     */
    public function puede($accion)
    {
        switch ($accion) {
            case 'ver':
                return true; // Todos pueden ver
            case 'crear':
            case 'editar':
                return $this->isAdministrador() || $this->isModerador();
            case 'eliminar':
                return $this->isAdministrador();
            default:
                return false;
        }
    }

    // Métodos de IdentityInterface
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'activo' => 1]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'activo' => 1]);
    }

    /**
     * Validates password
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Sets password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}