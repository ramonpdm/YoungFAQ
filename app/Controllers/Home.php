<?php

namespace App\Controllers;

use App\Core\Exceptions\UserNotFoundException;
use App\Repositories\Topic;

class Home extends App
{
    public function index()
    {
        try {
            $topicRepo = new Topic();
            $topics = $topicRepo->findAll();
            return $this->renderView('', ['topics' => $topics]);
        } catch (UserNotFoundException $e) {
            return $this->renderView('', ['error' => $e->getMessage()]);
        }
    }
}
