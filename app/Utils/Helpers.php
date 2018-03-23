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
        return [ '' => '-', 'MT' => 'MT', 'NR' => 'NR' ];
    }

    /**
     * @return array
     */
    public static function ComboReasons( $val = null, $render = false )
    {
        $data = [
            ''  => '-',
            'I' => 'INFRASTRUTTURA',
            'C' => 'ALLACCIO CLIENTI',
            'V' => 'VARIE',
        ];

        if ( $render ) {
            $data[ 'L' ] = trans('global.app_load_depo');
            $data[ 'M' ] = trans('global.app_movement_depo');
        }

        if ( $val ) {
            return $data[ $val ];
        }

        return $data;
    }
}