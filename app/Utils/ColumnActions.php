<?php
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