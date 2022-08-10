<?php

namespace App\InterfacesClass;

use App\Classe\Post;
use App\Models\Post as ModelsPost;
use App\Classe\User;

interface PostInterface {
    public function create(Post $post): ModelsPost;
    public function update(Post $post): ModelsPost;
    public function getById(Post $post): ModelsPost ;
    public function getAll(User $user): ModelsPost;
}
