<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Depot
 *
 * @package App
 */
class Depot extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'group_id',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo( Group::class );

    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeList( $query )
    {

        if ( !Auth::user()->isAn( 'administrator' ) ) {
            $query->where( 'group_id', '=', Auth::user()->group_id );
        }
        return $query;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany( Item::class )->withPivot( [
            'id', 'qta_ini', 'qta_depot', 'serial',
        ] )->withTimestamps();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function itemsActive()
    {
        return $this->belongsToMany( Item::class )->withPivot( [
            'id', 'qta_ini', 'qta_depot', 'serial',
        ] )
            ->wherePivot( 'qta_depot', '>', 0 )
            ->withTimestamps();
    }


    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name . " - " . $this->group->name;
    }
}
