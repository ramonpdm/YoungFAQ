<?php

namespace App\Core\Interfaces;

interface iCRUD
{
    public function find($id);
    public function create($emp);
    public function delete($emp);
    public function update($emp);
}
