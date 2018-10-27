<?php

// As added to composer.json file an autoload of app dir, this namespace will serve
// as include once or require once;
namespace Esened\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

        protected $table = 'users';

        protected $fillable = [
            'email',
            'name',
            'password',
        ];

        public function setPassword($password) {

            $this->update([               
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
        }

}