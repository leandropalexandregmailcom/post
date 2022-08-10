<?php

namespace App\Classe;

use DateTime;

class User{
    private int $id;
    private string $name;
    private int $email;
    private int $password;
    private DateTime $created_at;
    private DateTime $updated_at;

    public function __set($attribute, $value) {
        $this->$attribute = $value;
    }

    public function __get($attribute) {
        return $this->$attribute;
    }
}
