<?php
namespace App\InterfacesClass;

use App\Classe\Comment;
use App\Models\Comment as ModelsComment;

interface CommentInterface {
    public function create(Comment $comment): ModelsComment;
    public function update(Comment $comment): ModelsComment;
    public function getById(Comment $comment): ModelsComment ;
    public function getAll(Comment $comment): ModelsComment;
}
