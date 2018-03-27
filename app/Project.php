<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 *
 * @package App
 */
class Project extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'closed',
    ];


    /**
     * @var array
     */
    protected $casts = [
        'closed' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany( Item::class )
            ->withPivot( [ 'qta_req' ] )
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany( Group::class );
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOpen( $query )
    {
        return $query->where( 'closed', false );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movements()
    {
        return $this->hasMany( Movement::class );
    }


}
