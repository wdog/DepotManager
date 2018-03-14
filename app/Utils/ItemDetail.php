<?php


namespace App\Utils;


use Nayjest\Tree\ChildNodeTrait;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
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

        //dd( collect([$this->getData()]) );


        $provider = new ArrayDataProvider( collect( [ $this->getData() ] ) );
        $columns = [
            new Column( 'name', 'Item Name' ),
            new Column( 'um', 'Unit' ),
            new Column( 'pivot.qta_ini', 'Qta Ini' ),
            ( new Column( 'actions' ) )
                ->setValueCalculator( function ( $row ) {
                    return link_to_route( 'depots.edit', '', $row->id, [ 'class' => 'btn btn-xs btn-info fa fa-pencil' ] );

                } ),

        ];
        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );

        return $grid->render();
    }
}