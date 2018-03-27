<?php

namespace App\Utils;

use App\Item;
use App\Movement;
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

class ItemProjectDetail implements DataViewComponentInterface, ArrayDataAggregateInterface
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
        $project_id = $this->getData()->pivot->project_id;;


        $movements = Movement::with('user')
            ->where('project_id',$project_id)
            ->where('item_id',$item_id)
            ->orderBy( 'created_at', 'desc' )
            ->get();



       // return ( dump( $movements ) );



        $provider = new ArrayDataProvider( $movements );
        $columns = [
            new TableCaption( 'Movements Details:' ),
            ( new Column( 'depot', trans( 'global.depots.title' ) ) )
                ->setValueFormatter( function ( $val, $row ) {
                    return $row->depotItem->depot->name;
                } ),
            ( new Column( 'user.name', trans( 'global.users.title' ) ) ),
            ( new Column( 'updated_at', trans( 'global.app_last_update' ) ) )
                ->setValueFormatter( function ( $val ) {
                    return $val->format( 'd/m/Y H:i:s' );
                } ),
            ( new Column( 'qta', trans( 'global.qta' ) ) )
                ->setValueFormatter( function ( $val, $row ) {
                    return -1 * $val;
                } ),


        ];

        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'qta' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );
        return $grid;
    }
}