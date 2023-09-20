<?php

namespace App\Controllers;

use App\Helpers\HTTP;
use App\Repositories\Category as CategoryRepo;
use App\Repositories\Comment as CommentRepo;
use App\Repositories\Topic as TopicRepo;
use App\Repositories\TopicCategories as TopicCategoriesRepo;

use function App\Core\Functions\cleanFields;

class Topic extends App
{
    public function create()
    {
        if (\App\Models\User::isLogged() && isset($_POST['title'], $_POST['content'], $_POST['category'])) {
            $title = cleanFields($_POST['title']);
            $content = cleanFields($_POST['content']);
            $category = cleanFields($_POST['category']);

            if (empty($title) || empty($category) || empty($content))
                return HTTP::sendOutput(['message' => 'Favor completar correctamente todos los campos'], 400);

            try {
                $categoryRepo = new CategoryRepo();
                $categoryData = [
                    'name' => $category,
                    'created_by' => \App\Models\User::session()->getID(),
                ];

                // Verificar que exista la categoría
                $categoryInstance = @$categoryRepo->findByName($category);
                $categoryLastInsertID = 0;

                // Si existe, establecer el ID
                if ($categoryInstance instanceof \App\Models\Category) {
                    $categoryLastInsertID = $categoryInstance->getID() ?? 0;
                }

                // Si no existe la categoría, crearla
                if (!$categoryInstance instanceof \App\Models\Category) {
                    $categoryLastInsertID = @$categoryRepo->insert($categoryData);
                }

                // Verificar si se creó o se obtuvo el ID de la categoría
                if ($categoryLastInsertID === 0)
                    return HTTP::sendOutput(['message' => 'No se pudo crear la categoría deseada'], 500);

                $topicRepo = new topicRepo();
                $topicData = [
                    'title' => $title,
                    'content' => $content,
                    'created_by' => \App\Models\User::session()->getID(),
                ];

                // Crear la publicación
                $topicLastInsertID = @$topicRepo->insert($topicData);

                // Verificar si se creó
                if ($topicLastInsertID === 0)
                    return HTTP::sendOutput(['message' => 'No se pudo crear la publicación'], 500);

                $topicCategoriesRepo = new TopicCategoriesRepo();
                $topicCategoriesData = [
                    'id_topic' => $topicLastInsertID,
                    'id_category' => $categoryLastInsertID,
                    'created_by' => \App\Models\User::session()->getID(),
                ];

                // Registrar la relación de la categoría y la publicación
                if (@$topicCategoriesRepo->insert($topicCategoriesData) === 0)
                    return HTTP::sendOutput(['message' => 'No se pudo crear la relación de la categoría y la publicación'], 500);

                return HTTP::sendOutput(['message' => '¡Publicaión creada satisfactoriamente!']);
            } catch (\App\Core\Exceptions\DatabaseException $e) {
                return HTTP::sendOutput(['message' => 'No se pudo crear la publicación' . $e->getMessage()], 500);
            } catch (\Exception $e) {
                return HTTP::sendOutput(['message' => 'No se pudo crear la publicación'], 500);
            }
        }

        return HTTP::sendOutput(['message' => 'Ha habido un error. No se creó la publicación.'], 500);
    }

    public function view()
    {
        try {
            $id = $_GET['id'] ?? null;
            $topicRepo = new TopicRepo();
            $topic = $topicRepo->find($id);

            if (!$topic instanceof \App\Models\Topic)
                throw new \Exception('Publicacion no encontrada');

            $commentRepo = new CommentRepo();
            $comments = $commentRepo->findTopicComments($topic->getID());

            return $this->renderView('Pages/Topic', ['topic' => $topic, 'comments' => $comments]);
        } catch (\Exception $e) {
            return $this->renderView('Pages/Error', ['error' => $e->getMessage()]);
        }
    }
}
