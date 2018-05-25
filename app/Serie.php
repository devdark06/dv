<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $fillable = ['serie'];

    public function setSerieAttribute($value)
    {
        $this->attributes['serie'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
