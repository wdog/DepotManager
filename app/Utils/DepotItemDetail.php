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

/**
 * Class DepotItemDetail
 *
 * @package App\Utils
 */
class DepotItemDetail implements DataViewComponentInterface, ArrayDataAggregateInterface
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
    }


    /**
     * @param $data
     * @return Grid
     */
    public function show( $data )
    {
        $pivot_id = $data->pivot->id;
        $depotItem = DepotItem::find( $pivot_id );
        $movements = $depotItem->movements;
        $provider = new ArrayDataProvider( $movements );
        $columns = [
            new TableCaption( "Movement Details: <h3>{$data->name}</h3>" ),
            ( new Column( 'qta', trans( 'global.qta' ) ) )
                ->setValueFormatter( function ( $val ) {
                    return "<span class='badge badge-success'>" . $val . "</span>";
                } ),
            ( new Column( 'reason', trans( 'global.reason' ) ) )
                ->setValueFormatter( function ( $val, $row ) {


                    $rs = "";
                    if ( $val ) {
                        $rs .= "<span class='badge badge-warning'>" . Helpers::ComboReasons( $val, true ) . "</span> ";
                    }
                    if ( $row->project ) {
                        $rs .= "<span class='badge badge-danger'>" . $row->project->name . "</span> ";
                    }
                    $rs .= "<span class='badge badge-info'>" . $row->user->name . "</span> ";
                    $rs .= ' <small><span class="fa fa-clock-o " aria-hidden="true"></span> ' . $row->created_at->format( 'd/m/Y H:i:s' ) . "</small>";

                    return $rs;

                } ),

        ];

        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'qta' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );


        return $grid;

    }

}