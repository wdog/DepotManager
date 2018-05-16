<?php

namespace App\Utils;

use App\Item;
use Nayjest\Tree\ChildNodeTrait;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\TableCaption;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateInterface;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateTrait;
use ViewComponents\ViewComponents\Data\ArrayDataProvider;
use ViewComponents\ViewComponents\Data\DataAggregateInterface;
use ViewComponents\ViewComponents\Rendering\ViewTrait;

class ItemDetail implements DataViewComponentInterface, ArrayDataAggregateInterface
{
    use ChildNodeTrait;
    use ViewTrait;
    use ArrayDataAggregateTrait;

    /**
     * ItemDetail constructor.
     *
     * @param null $data
     * @internal param $item_id
     */
    public function __construct( $data = null )
    {
        $this->setData( $data );
    }

    public function render()
    {
        $item_id = $this->getData()->id;
        //$item_depots = Item::find( $item_id )->depots;
        $item_depots = Item::find( $item_id )->depots->where('pivot.qta_depot','>',0);
        //dump($item_depots);
        $provider = new ArrayDataProvider( $item_depots );
        $columns = [
            new TableCaption( 'Item Details' ),
            ( new Column( 'name', trans('global.depots.title') ) ),
            ( new Column( 'group.name', trans('global.groups.title') ) ),
            ( new Column( 'pivot.updated_at', trans('global.app_last_update') ) )->setValueFormatter( function ( $val, $row ) {

                return $val->format( 'd/m/Y H:i:s' );
            } ),
            ( new Column( 'pivot.qta_depot', trans('global.qta') ) ),


        ];

        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'pivot.qta_depot' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );
        //     $grid->getColumn( 'pivot.qta_ini' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        return $grid;
    }
}