<?php

namespace App\Controllers;

use App\Helpers\HTTP;
use App\Models\User;
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
                    return HTTP::sendOutput(['message' => '¡Inicio de sesión exitoso!']);

                return HTTP::sendOutput(['message' => 'Hubo un error en el sistema'], 500);
            }
        }

        return HTTP::sendOutput(['message' => 'Usuario y/o contraseña incorrectos'], 404);
    }

    public function register()
    {
        if (isset($_POST['usernameReg'], $_POST['passwordReg'], $_POST['firstname'], $_POST['lastname'], $_POST['email'],)) {
            $username = cleanFields($_POST['usernameReg']);
            $password = cleanFields($_POST['passwordReg']);
            $firstname = cleanFields($_POST['firstname']);
            $lastname = cleanFields($_POST['lastname']);
            $email = cleanFields($_POST['email']);

            if (empty($username) || empty($password) || empty($firstname) || empty($lastname) || empty($email))
                return HTTP::sendOutput(['message' => 'Favor completar correctamente todos los campos'], 400);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                return HTTP::sendOutput(['message' => 'Favor proporcionar un correo electrónico válido'], 400);

            $userRepo = new UserRepo();
            $data = [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email,
                'level' => 2,
            ];

            try {
                $lastInsertId = $userRepo->insert($data);
                $data['id'] = $lastInsertId;

                if ($lastInsertId === 0)
                    return HTTP::sendOutput(['message' => 'No se pudo completar el registro'], 400);

                $user = new User($data);
                $user->validateInstance();

                if ($user->setParams() && $user->isLogged())
                    return HTTP::sendOutput(['message' => '¡Registro exitoso!']);
            } catch (\App\Core\Exceptions\DatabaseException $e) {
                if ($e->getCode() === 23000)
                    return HTTP::sendOutput(['message' => 'Este usuario ya está ocupado, por favor, elige otro.'], 400);
                return HTTP::sendOutput(['message' => 'Hubo un error en el sistema'], 500);
            } catch (\Exception $e) {
                return HTTP::sendOutput(['message' => 'No se pudo completar el registro'], 400);
            }
        }

        return HTTP::sendOutput(['message' => 'Hubo un error en el sistema'], 500);
    }

    public function logout()
    {
        session_destroy();
        return HTTP::redirect('/');
    }
}
