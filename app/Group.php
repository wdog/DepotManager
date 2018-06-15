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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany( Project::class );
    }

    /**
     * @param $value
     */
    public function setNameAttribute( $value )
    {
        $this->attributes[ 'name' ] = strtoupper( $value );
    }
}
