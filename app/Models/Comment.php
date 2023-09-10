<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Exceptions\UserNotFoundException;

use App\Repositories\User as UserRepo;

class Comment extends Model
{
    // Internal Database Props
    protected $id;
    protected $id_topic;
    protected $content;
    protected $status;
    protected $created_by;
    protected $created_at;
    protected $reviewed_by;
    protected $reviewed_at;
    protected $updated_by;
    protected $updated_at;

    // Virtual Props
    protected \App\Models\User $author;

    public function __construct($data = null)
    {
        $userRepo = new UserRepo();
        $author = $userRepo->find($this->created_by);

        if ($author === null)
            throw new UserNotFoundException('No se pudo obtener los datos del creador del comentario <b><i>"' . $this->getID() . '"</b></i> correctamente.  <b>ID del Creador: ' . $this->created_by . '</b>');

        $this->author = $author;
    }

    /** 
     * Comment ID getter
     * 
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }

    /** 
     * Comment content getter
     * 
     * @return int
     */
    public function getContent()
    {
        return $this->content;
    }

    /** 
     * Comment author getter
     * 
     * @return \App\Models\User
     */
    public function getAuthor(): \App\Models\User
    {
        return $this->author;
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
