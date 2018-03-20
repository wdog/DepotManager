<?php
/**
 * Created by PhpStorm.
 * User: chech
 * Date: 19/03/18
 * Time: 12.24
 */

namespace App\Utils;


use ViewComponents\Grids\Component\Column;
use ViewComponents\ViewComponents\Component\TemplateView;

class ColumnActions extends Column
{
    public function __construct( ?string $columnId, ?string $label = null )
    {
        parent::__construct( $columnId, $label );
        $this->dataView = new TemplateView( 'column/column-actions' );
    }


}