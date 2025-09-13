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
    const ROL_MODERADOR = 'Moderador';
    const ROL_ASISTENTE = 'Asistente';

    // ... (todo el código existente se mantiene igual)

    /**
     * Verifica si el usuario es administrador
     * @return bool
     */
    public function isAdministrador()
    {
        return $this->rol === self::ROL_ADMINISTRADOR;
    }

    /**
     * Verifica si el usuario es moderador
     * @return bool
     */
    public function isModerador()
    {
        return $this->rol === self::ROL_MODERADOR;
    }

    /**
     * Verifica si el usuario es asistente
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

    // Métodos de IdentityInterface para autenticación
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
}