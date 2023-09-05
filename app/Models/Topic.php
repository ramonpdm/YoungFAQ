<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Exceptions\UserNotFoundException;

use App\Repositories\User as UserRepo;
use App\Repositories\TopicCategories as TopicCategoriesRepo;

class Topic extends Model
{
    // Internal Database Props
    protected $id;
    protected $title;
    protected $content;
    protected $status;
    protected $created_by;
    protected $created_at;
    protected $reviewed_by;
    protected $reviewed_at;
    protected $updated_by;
    protected $updated_at;

    // Virtual Props
    protected $comments_count;
    protected \App\Models\User $author;

    /** @var \App\Models\Category[] */
    protected array $categories;

    public function __construct($data = null)
    {
        $userRepo = new UserRepo();
        $this->author = $userRepo->find($this->created_by);

        $categoriesRepo = new TopicCategoriesRepo();
        $this->categories = $categoriesRepo->findTopicCategories($this->id);

        if ($this->author === null)
            throw new UserNotFoundException('No se pudo obtener los datos del creador de la pulicación <b><i>"' . $this->getTitle() . '"</b></i> correctamente.  <b>ID del Creador: ' . $this->created_by . '</b>');
    }

    /** 
     * Topic ID getter
     * 
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }

    /** 
     * Topic title getter
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /** 
     * Topic content getter
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /** 
     * Topic comments count getter
     * 
     * @return string
     */
    public function getCommentsCount()
    {
        return $this->comments_count;
    }

    /** 
     * Topic author getter
     * 
     * @return \App\Models\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /** 
     * Topic categories getter
     * 
     * @return \App\Models\Category
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /** 
     * Topic created at getter
     * 
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return new \DateTime($this->created_at);
    }
}
