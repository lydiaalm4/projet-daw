<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class utilisateur extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'firstName',
        'email',
        'password',
        'phone',
        'photo',
        'domaine'
    ];

}
