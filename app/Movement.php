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
        'movement_id',
        'project_id',
        'reason',
    ];

    /**
     *
     */
    public function user()
    {
        return $this->belongsTo( User::class );
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo( Project::class );
    }
}
