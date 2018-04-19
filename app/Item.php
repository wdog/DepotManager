<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SahusoftCom\EloquentImageMutator\EloquentImageMutatorTrait;

/**
 * Class Item
 *
 * @package App
 */
class Item extends Model
{
    use EloquentImageMutatorTrait;
    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'vendor_id',
        'um',
        'disabled',
        'item_image',
    ];

    protected $image_fields = [ 'item_image' ];

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

    /**
     * @return mixed
     */
    public function available()
    {
        return $this->depots()->sum( 'qta_depot' );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany( Project::class )->withPivot( [
            'id', 'qta_req',
        ] )->withTimestamps();
    }


    /**
     * get movements of an item
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function movements()
    {
        return $this->hasManyThrough( Movement::class, DepotItem::class );

    }

    /**
     * @param $value
     */
    public function setNameAttribute( $value )
    {
        $this->attributes[ 'name' ] = strtoupper( $value );
    }

}
