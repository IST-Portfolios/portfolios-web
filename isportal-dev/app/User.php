<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;

class User extends Authenticable
{
    public function activities(){
        return $this->hasMany(Activity::class, 'creator_id');
    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class, 'entity_id');
    }

    //TODO -> Alunos deverão dizer periodo de execução de actividades;
}