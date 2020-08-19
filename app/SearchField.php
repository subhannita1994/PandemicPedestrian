<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchField extends Model
{
    //
    protected $fillable = [
        'sequence','documentID', 'placeID', 'name', 'lat','lng'
    ];
}
