<?php

namespace App\Utils;

class Helpers
{
    public static function renderBool( $value )
    {
        if ( $value ) {
            return "DISABLED";
        } else {
            return "ENABLED";
        }

    }


    public static function ComboUnita()
    {
        return [ '' => '---', 'MT' => 'MT', 'NR' => 'NR' ];
    }

    public static function ComboReasons()
    {
        return [
            ''  => '---',
            'I' => 'INFRASTRUTTURA',
            'C' => 'ALLACCIO CLIENTI',
        ];
    }
}