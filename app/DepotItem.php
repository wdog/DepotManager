<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DepotItem
 *
 * @package App
 */
class DepotItem extends Model
{

    /**
     * @var string
     */
    protected $table = 'depot_item';
    /**
     *
     * @var array
     */
    protected $fillable = [
        'id', 'qta_ini', 'qta_depot', 'serial',

    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movements()
    {
        return $this->hasMany( Movement::class );
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo( Group::class );
    }
}
