<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemProject
 *
 * @package App
 */
class ItemProject extends Model
{

    /**
     * @var string
     */
    protected $table = 'item_project';
    /**
     * @var array
     */
    protected $fillable = [
        'item_id',
        'project_id',
        'qta_req',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo( Project::class );
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo( Item::class );
    }


}
