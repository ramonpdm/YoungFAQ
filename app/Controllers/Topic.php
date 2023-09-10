<?php

namespace App\Controllers;

use App\Helpers\HTTP;
use App\Repositories\Category;
use App\Repositories\Comment;
use App\Repositories\Topic as TopicRepo;

use function App\Core\Functions\cleanFields;

class Topic extends App
{
    public function index()
    {
        if (\App\Models\User::isLogged() && isset($_POST['title'], $_POST['category'], $_POST['content'])) {

            try {
                $categoryRepo = new Category();
                $category = cleanFields($_POST['category']);
                $category = @$categoryRepo->findByName($category);

                if (is_null($category))
                    $category = @$categoryRepo->insert($category);

                $topicRepo = new TopicRepo();

                if (@$topicRepo->insert([
                    'title' => cleanFields($_POST['title']),
                    'content' => cleanFields($_POST['content']),
                ]))
                    return HTTP::sendOutput(['message' => 'Se creó la publicación correctamente']);
            } catch (\Exception $e) {
                return HTTP::sendOutput(['message' => $e->getMessage()], 500);
            }
        }

        return HTTP::sendOutput(['message' => 'Ha habido un error. No se creó la publicación.'], 400);
    }

    public function view()
    {
        try {
            $id = $_GET['id'] ?? null;
            $topicRepo = new TopicRepo();
            $topic = $topicRepo->find($id);

            if (!$topic instanceof \App\Models\Topic)
                throw new \Exception('Publicacion no encontrada');

            $commentRepo = new Comment();
            $comments = $commentRepo->findTopicComments($topic->getID());

            return $this->renderView('Pages/Topic', ['topic' => $topic, 'comments' => $comments]);
        } catch (\Exception $e) {
            return $this->renderView('Pages/Error', ['error' => $e->getMessage()]);
        }
    }
}
