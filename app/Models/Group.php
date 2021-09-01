<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Organiser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Scope;

class Group extends Model
{
    protected $fillable = ['name', 'town', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function organiser()
    {
        return $this->belongsTo(Organiser::class);
    }

}
