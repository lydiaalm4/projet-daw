<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userr extends Model
{
    public $timestamps = false;
    protected $table = 'users' ;
    protected $fillable = [
        'name',
        'firstName',
        'email',
        'password',
        'phone',
        'photo',
        'domaine',
        'type'
    ];
    public function student (){
        return $this->belongsTo(student::class,'id');
    }
}
