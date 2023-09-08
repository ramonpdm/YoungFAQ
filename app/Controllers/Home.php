<?php

namespace App\Controllers;

use App\Core\Exceptions\UserNotFoundException;
use App\Repositories\Topic;

class Home extends App
{
    protected function index()
    {
        try {
            $topicRepo = new Topic();
            $topics = $topicRepo->findAll();
            return $this->renderView('Pages/Home', ['topics' => $topics]);
        } catch (UserNotFoundException $e) {
            return $this->renderView('Pages/Error', ['error' => $e->getMessage()]);
        }
    }
}
