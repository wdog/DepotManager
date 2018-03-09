<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Silber\Bouncer\Database\HasRolesAndAbilities;

/**
 * Class Group
 *
 * @package App
 */
class Group extends Model
{

    /**
     * @var array
     */
    protected $fillable = [ 'name', 'slug' ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany( User::class );
    }
}
