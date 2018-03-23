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
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function items()
    {
        return $this->belongsTo( Items::class );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany( Group::class );
    }

}
