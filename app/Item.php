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

    /**
     * @var array
     */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function depots()
    {
        return $this->belongsToMany( Depot::class )->withPivot( [
            'id', 'qta_ini', 'qta_depot', 'serial',
        ] )->withTimestamps();
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->code . " - " . $this->name . " - " . $this->um;
    }
}
