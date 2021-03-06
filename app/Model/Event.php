<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model 
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'date'];
}
