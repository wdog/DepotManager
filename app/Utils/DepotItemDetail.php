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
            new TableCaption( 'Movement Details: ' . $data->name ),
            ( new Column( 'qta', trans( 'global.qta' ) ) ),
            ( new Column( 'reason', trans( 'global.reason' ) ) )->setValueFormatter( function ( $val, $row ) {

                $rs = "<ul class='list-group'>";
                if ( $row->project ) {
                    $rs .= "<li class='list-group-item list-group-item-dark   '>" . $row->project->name . "</li>";
                }
                if ( $val ) {
                    $rs .= "<li class='list-group-item list-group-item-dark '>" . Helpers::ComboReasons( $val, true ) . "</li>";
                }

                $rs .= "<li class='list-group-item list-group-item-info '>" . trans( 'global.app_from' ) . ":  " . $row->user->name . " ";
                $rs .= '<i class="fa fa-clock-o " aria-hidden="true"></i> ' . $row->created_at->format( 'd/m/Y H:i:s' ) . "</li>";

                $rs .= "</ul>";
return $rs;

            } ),

        ];

        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'qta' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );


        return $grid;

    }

}