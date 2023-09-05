<?php

namespace App\Controllers;

use App\Helpers\HTTP;

class Logout extends App
{
    public function index()
    {
        session_destroy();
        return HTTP::redirect('/');
    }
}
