<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Hash;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndAbilities;


    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'group_id',

    ];


    /**
     * Hash password
     *
     * @param $input
     */
    public function setPasswordAttribute( $input )
    {
        if ( $input )
            $this->attributes[ 'password' ] = app( 'hash' )->needsRehash( $input ) ? Hash::make( $input ) : $input;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo( Group::class );
    }


}
