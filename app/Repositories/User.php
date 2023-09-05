<?php

namespace App\Repositories;

use App\Core\Query;

class User extends Query
{
    protected $model = \App\Models\User::class;
    protected $db_table = 'users';

    /** 
     * Devuelve un usuario por su nombre de usuario.
     * 
     * @param string $username 
     * @return \App\Models\User|null     
     */
    public function findByUsername($username)
    {
        return $this->select("SELECT * FROM $this->db_table WHERE username = :username", [[":username", $username]])[0] ?? null;
    }
}
