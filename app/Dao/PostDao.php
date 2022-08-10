<?php

namespace App\Dao;

use App\Classe\Post;
use App\Classe\User;
use App\InterfacesClass\PostInterface;
use App\Models\Post as ModelsPost;

class PostDao implements PostInterface {

    private ModelsPost $model;

    public function __constructor() {
        $this->model = new ModelsPost;
    }

    public function create(Post $post): ModelsPost {
        $this->model->create([
            'description'   => $post->description,
            'user_id'       => $post->user_id
        ]);
        return $this->model;
    }

    public function update(Post $post): ModelsPost {
        $this->model->where([
            'post_id' => $post->id,
            'user_id' => $post->user_id
        ])
        ->update([
            'description'   => $post->description,
        ]);
        return $this->model;
    }

    public function getById(Post $post): ModelsPost  {
        $this->model->where([
            'post_id' => $post->id,
            'user_id' => $post->user_id
        ])->first();

        return $this->model;
    }

    public function getAll(User $user): ModelsPost {
        $this->model->get();

        return $this->model;
    }
}
