<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'town', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
