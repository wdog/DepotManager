<?php


namespace App\Utils;


use App\DepotItem;
use function mp\setValue;
use Nayjest\Tree\ChildNodeTrait;
use ViewComponents\Grids\Component\AjaxDetailsRow;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\TableCaption;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\Html\TagWithText;
use ViewComponents\ViewComponents\Component\Part;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateInterface;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateTrait;
use ViewComponents\ViewComponents\Data\ArrayDataProvider;
use ViewComponents\ViewComponents\Rendering\ViewTrait;

class ItemDetail implements DataViewComponentInterface, ArrayDataAggregateInterface
{
    use ChildNodeTrait;
    use ViewTrait;
    use ArrayDataAggregateTrait;

    /**
     * Constructor.
     *
     * @param mixed $data data to render
     */
    public function __construct( $data = null )
    {
        $this->setData( $data );
    }

    /**
     * Renders data.
     *
     * @return string
     */
    public function render()
    {


        $data = $this->getData();
        return $this->show( $data );


        $provider = new ArrayDataProvider( collect( [ $this->getData() ] ) );
        $columns = [

            new Column( 'name', 'Item Name' ),
            ( new Column( 'pivot.qta_ini', 'Qta Initial' ) )
                ->setValueCalculator( function ( $row ) {
                    return $row->pivot->qta_ini . " " . $row->um . ".";
                } ),


        ];
        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'pivot.qta_ini' )->getDataCell()->setAttribute( 'class', 'text-right' );
        return $grid;
    }


    public function show( $data )
    {


        $pivot_id = $data->pivot->id;
        $depotItem = DepotItem::find( $pivot_id );
        $movements = $depotItem->movements;


        $provider = new ArrayDataProvider( $movements );
        $columns = [
            new TableCaption( 'Movements Detail' ),

            new Part( new Tag( 'tr' ), 'control_row2', 'table_heading' ),

            new Part( new TagWithText( 'td', $data->pivot->qta_ini ), 'name-c-row', 'control_row2' ),
            new Part( new TagWithText( 'td', $data->name ), 'qta_ini-c-row', 'control_row2' ),
            new Part( new TagWithText( 'td', 'SYSTEM' ), 'uploader-c-row', 'control_row2' ),
            new Part( new TagWithText( 'td', $data->pivot->created_at->format('d-m-Y H:i:s') ), 'dt_load-c-row', 'control_row2' ),


            ( new Column( 'qta' ) )
                ->setValueFormatter( function ( $val ) {
                    return -1 * $val;
                } ),
            ( new Column( 'reason' ) ),
            ( new Column( 'user.name' ) ),
            ( new Column( 'created_at', 'Dt' ) )
                ->setValueFormatter( function ( $val ) {
                    return $val->format( 'd-m-Y H:i:s' );
                } ),
        ];


        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'qta' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );
        $grid->getColumn( 'created_at' )->getDataCell()->setAttribute( 'class', 'text-right' );

        return $grid;

    }

}