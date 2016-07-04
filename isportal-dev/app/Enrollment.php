<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

    public function activity(){
    	return $this->belongsTo(Activity::class);
    }

    public function entity(){
        return $this->belongsTo(User::class);
    }

}
