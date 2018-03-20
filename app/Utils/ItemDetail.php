<?php
/**
 * Created by PhpStorm.
 * User: chech
 * Date: 20/03/18
 * Time: 17.15
 */

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
     * @param $item_id
     */
    public function __construct( $data = null )
    {
        $this->setData( $data );

    }

    public function render()
    {
        $item_id =$this->getData()->id;

        $depots = Item::find( $item_id )->depots;

        $provider = new ArrayDataProvider( $depots );
        $columns = [
            new TableCaption( 'Item Details:' ),
            ( new Column( 'name' )),
            ( new Column( 'group.name' )),
            ( new Column( 'pivot.qta_depot' ,'QTA')),
        //    ( new Column( 'pivot.qta_ini' ,'QTA INI')),
            ( new Column( 'updated_at','update' ) )->setValueFormatter( function ( $val ) {
                return $val->format('d/m/Y H:i:s');

            } ),

        ];

        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'pivot.qta_depot' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );
   //     $grid->getColumn( 'pivot.qta_ini' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        return $grid;
    }


}