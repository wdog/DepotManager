<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'vendor_id',
        'um',
        'disabled'
    ];


}
