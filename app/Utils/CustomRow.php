<?php
/**
 * Created by PhpStorm.
 * User: chech
 * Date: 19/03/18
 * Time: 13.01
 */

namespace App\Utils;


use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\ManagedList\RecordView;

class CustomRow extends RecordView
{
    public function __construct()
    {
        $view = new Tag( 'tr', [ 'style' => 'color:red' ] );
        parent::__construct($view );
    }



}