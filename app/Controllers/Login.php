<?php

namespace App\Controllers;

use App\Helpers\HTTP;
use App\Repositories\User as UserRepo;

use function App\Core\Functions\cleanFields;

class Login extends App
{
    public function index()
    {
        if (isset($_POST['username'], $_POST['password'])) {

            $username = cleanFields($_POST['username']);
            $password = cleanFields($_POST['password']);

            if (empty($username) || empty($password))
                return HTTP::sendOutput(['message' => 'Favor completar correctamente todos los campos'], 400);

            $userRepo = new UserRepo();
            $user = $userRepo->findByUsername($username);

            if (is_object($user) && $user->isPasswordValid($password)) {

                if ($user->setParams())
                    return HTTP::sendOutput(['message' => '¡Inicio  de sesión exitoso!']);

                return HTTP::sendOutput(['message' => 'Hubo un error en el sistema'], 500);
            }
        }

        return HTTP::sendOutput(['message' => 'Usuario y/o contraseña incorrectos'], 404);
    }
}
