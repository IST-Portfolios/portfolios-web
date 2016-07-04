<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function activities(){
        return $this->hasMany(Activity::class, 'creator_id');
    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class, 'entity_id');
    }


    //TODO -> Alunos deverão dizer periodo de execução de actividades;
}