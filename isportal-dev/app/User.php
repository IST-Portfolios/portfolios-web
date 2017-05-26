<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function activities(){
        return $this->hasMany(Activity::class, 'creator_id');
    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class, 'entity_id');
    }

    //TODO -> Alunos deverão dizer periodo de execução de actividades;
}