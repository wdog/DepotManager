<?php

namespace App\Utils;

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
    public static function ComboReasons()
    {
        return [
            ''  => '---',
            'I' => 'INFRASTRUTTURA',
            'C' => 'ALLACCIO CLIENTI',
        ];
    }
}