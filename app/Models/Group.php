<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    protected $fillable = ['name', 'town', 'email'];
   
        public function group()
    {
        return $this->belongsTo(\App\Models\Organiser::class);
    }

}     
