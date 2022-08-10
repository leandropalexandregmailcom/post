<?php

namespace App\Dao;

use App\Classe\Comment;
use App\InterfacesClass\CommentInterface;
use App\Models\Comment as ModelsComment;

class CommentDao  {

    private ModelsComment $model;

    public function __constructor() {

    }

    public function create(Comment $comment): ModelsComment {
        $model = new ModelsComment;
        $model->create([
            'description'   => $comment->description,
            'user_id'       => $comment->user_id,
            'post_id'       => $comment->user_id
        ]);
        return $model;
    }

    public function update(Comment $comment): ModelsComment {
        $model = new ModelsComment;
        $model->where([
            'id' => $comment->id,
            'user_id' => $comment->user_id,
            'post_id'       => $comment->user_id
        ])
        ->update([
            'description'   => $comment->description,
        ]);
        return $model;
    }

    public function getById(Comment $comment): ModelsComment  {
        $model = new ModelsComment;
        $model->where([
            'id' => $comment->id,
            'user_id' => $comment->user_id,
            'post_id' => $comment->user_id
        ])->first();

        return $model;
    }

    public function getAll(Comment $comment) {
        $comment = new ModelsComment;
        return $comment->get();
    }
}
