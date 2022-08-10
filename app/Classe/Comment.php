<?php

namespace App\Classe;

use DateTime;

class Comment {
    private int $id;
    private string $description;
    private int $user_id;
    private int $post_id;
    private DateTime $created_at;
    private DateTime $updated_at;

    public function __set($attribute, $value) {
        $this->$attribute = $value;
    }

    public function __get($attribute) {
        return $this->$attribute;
    }
}
