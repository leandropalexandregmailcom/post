<?php

namespace App\Dao;

use App\Classe\Like;
use App\InterfacesClass\LikeInterface;
use App\Models\Like as ModelsLike;

class LikeDao implements LikeInterface {

    private ModelsLike $model;

    public function __constructor() {
        $this->model = new ModelsLike;
    }

    public function create(Like $like): ModelsLike {
        $this->model->create([
            'like'   => $like->like,
            'user_id'       => $like->user_id,
            'post_id'       => $like->user_id
        ]);
        return $this->model;
    }

    public function update(Like $like): ModelsLike {
        $this->model->where([
            'id' => $like->id,
            'user_id' => $like->user_id,
            'post_id'       => $like->user_id
        ])
        ->update([
            'like'   => $like->like,
        ]);
        return $this->model;
    }

    public function getById(Like $like): ModelsLike  {
        $this->model->where([
            'id' => $like->id,
            'user_id' => $like->user_id,
            'post_id' => $like->user_id
        ])->first();

        return $this->model;
    }

    public function getAll(Like $like): ModelsLike {
        $this->model->get();

        return $this->model;
    }
}
