<?php

namespace App\Models;

use App\Core\Model;
use App\Repositories\Topic;

class User extends Model
{
    /**
     * Constantes que se crean en la sesión 
     * cuando un usuario se loguea.
     */
    const SESSION_LABEL_ID = 'USER_ID';
    const SESSION_LABEL_USERNAME = 'USERNAME';
    const SESSION_LABEL_FIST_NAME = 'USER_FNAME';
    const SESSION_LABEL_LAST_NAME = 'USER_LNAME';
    const SESSION_LABEL_FULL_NAME = 'USER_FULL_NAME';
    const SESSION_LABEL_LEVE = 'USER_LEVEL';

    // Internal Database Props
    protected $id;
    protected $username;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $level;
    protected $password;

    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /** 
     * User ID getter
     * 
     * @return string
     */
    public function getID()
    {
        return $this->id;
    }

    /** 
     * User username getter
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /** 
     * User full name getter
     * 
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /** 
     * Devuelve 'true' si el usuario es un
     * administrador.
     * 
     * @return boolean
     */
    public function isAdmin()
    {
        if ($this->level == 1)
            return true;

        return false;
    }

    /**
     * Verificar que una contraseña coincida
     * con el hash.
     *
     * @param string
     */
    public function isPasswordValid($password)
    {
        return password_verify($password, $this->password);
    }

    /**
     * Establecer los parámetros del 
     * usuario en la sesión.
     *
     */
    public function setParams()
    {
        $_SESSION[self::SESSION_LABEL_ID]          = $this->id;
        $_SESSION[self::SESSION_LABEL_USERNAME]    = $this->username;
        $_SESSION[self::SESSION_LABEL_FIST_NAME]   = $this->first_name;
        $_SESSION[self::SESSION_LABEL_LAST_NAME]   = $this->last_name;
        $_SESSION[self::SESSION_LABEL_FULL_NAME]   = $this->getFullName();
        $_SESSION[self::SESSION_LABEL_LEVE]       = $this->level;

        return true;
    }

    /** 
     * Devuelve las publicaciones creadas
     * por el usuario de la instancia.
     * 
     * @return App\Models\Topic[]
     */
    public function getUserTopics()
    {
        $topicRepo = new Topic();
        return $topicRepo->findTopicsByCreator($this->id);
    }

    /** 
     * Devuelve 'true' si hay un usuario logueado.
     * 
     * @return boolean
     */
    static public function isLogged()
    {
        if (isset(
            $_SESSION[self::SESSION_LABEL_ID],
            $_SESSION[self::SESSION_LABEL_USERNAME],
            $_SESSION[self::SESSION_LABEL_FIST_NAME],
            $_SESSION[self::SESSION_LABEL_LAST_NAME],
            $_SESSION[self::SESSION_LABEL_FULL_NAME],
            $_SESSION[self::SESSION_LABEL_LEVE]
        )) {
            if (
                !empty($_SESSION[self::SESSION_LABEL_ID])
                && !empty($_SESSION[self::SESSION_LABEL_USERNAME])
                && !empty($_SESSION[self::SESSION_LABEL_FIST_NAME])
                && !empty($_SESSION[self::SESSION_LABEL_LAST_NAME])
                && !empty($_SESSION[self::SESSION_LABEL_FULL_NAME])
                && !empty($_SESSION[self::SESSION_LABEL_LEVE])
            )
                return true;
        }

        return false;
    }

    /** 
     * Devuelve una instancia de un
     * usuario con sus datos si está 
     * logueado.
     * 
     * @return User
     */
    static public function session(): User
    {
        if (!self::isLogged())
            return new User();

        $userRepo = new \App\Repositories\User();
        return $userRepo->find($_SESSION[self::SESSION_LABEL_ID]) ?? new User();
    }
}
