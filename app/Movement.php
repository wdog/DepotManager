<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Movement
 *
 * @package App
 */
class Movement extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'qta',
        'info',

    ];

    /**
     *
     */
    public function user()
    {
        return $this->belongsTo( User::class );
    }


    public function item()
    {
        return $this->belongsTo( Item::class );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo( Group::class );
    }
}
