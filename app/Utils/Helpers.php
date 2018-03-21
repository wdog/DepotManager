<?php

namespace App\Utils;

use Illuminate\Support\Facades\Auth;

/**
 * Class Helpers
 *
 * @package App\Utils
 */
class Helpers
{
    /**
     * @param $value
     * @return string
     */
    public static function renderBool( $value )
    {
        if ( $value ) {
            return "DISABLED";
        } else {
            return "ENABLED";
        }
    }

    /**
     * @return array
     */
    public static function ComboUnita()
    {
        return [ '' => '---', 'MT' => 'MT', 'NR' => 'NR' ];
    }

    /**
     * @return array
     */
    public static function ComboReasons( $val = null, $render = false )
    {
        $data = [
            ''  => '---',
            'I' => 'INFRASTRUTTURA',
            'C' => 'ALLACCIO CLIENTI',
            'V' => 'VARIE',
        ];

        if ( $render ) {
            $data[ 'L' ] = 'DEPOT LOAD';
            $data[ 'M' ] = 'MOVE INTRA DEPOT';
        }

        if ( $val ) {
            return $data[ $val ];
        }

        return $data;
    }
}