<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 *
 * @package App
 */
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
        'disabled',
    ];


    protected $casts = [
        'disabled' => 'boolean',
    ];



    /**
     * SCOPE only elemenents who can be stored into a depot
     *
     * @param $query
     * @return mixed
     */
    public function scopeEnabled( $query )
    {
        return $query->whereDisabled( false );
    }

}
