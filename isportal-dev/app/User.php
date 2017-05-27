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
        'name', 'email', 'password','type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
        Verify if the user as the enrrol process completed
        Completed = 3 regular activities or 1 coaching activity
    */
    public function enrollProcessComplete() {
        $enrollments = $this->enrollments();
        $enrrolCount = 0;
        foreach ($enrollments as $enrr) {
            $activityType = $enrr->activity()->type;
            if($activityType == 'regular') {
                $enrrolCount++;
            }
            else if($activityType == 'coaching'){
                return true;
            }
        }
        return $enrrolCount == 3;
    }

    public function activities(){
        return $this->hasMany(Activity::class, 'creator_id');
    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class, 'entity_id');
    }


    //TODO -> Alunos deverão dizer periodo de execução de actividades;
}