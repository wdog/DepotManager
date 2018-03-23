<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemProject extends Model
{
    protected $fillable = [
        'item_id',
        'group_id',
        'qta_req',
    ];
}
