<?php

namespace App\InterfacesClass;

use App\Classe\Like;
use App\Models\Like as ModelsLike;

interface LikeInterface {
    public function create(Like $like): ModelsLike;
    public function update(Like $like): ModelsLike;
    public function getById(Like $like): ModelsLike ;
    public function getAll(Like $like): ModelsLike;
}
