<?php
use ViewComponents\ViewComponents\Customization\CssFrameworks\Bootstrap\ViewHelper;

$useIcons = true;
$helper = new ViewHelper( [
    'baseButtonClass'         => 'btn',
    'buttonSizeClass'         => 'btn-sm',
    'defaultButtonStyleClass' => 'btn-info',

    'baseTableClass'         => 'table',
    'defaultTableStyleClass' => 'table-striped table-hover table-bordered p-0',

    'baseInputClass' => 'form-control',
    'inputSizeClass' => 'input-sm',
] );

return [
    'root'                                   => [],
    'compound_part#form'                     => 'add_class:form-inline',
    'tag&property:type,submit'               => [
        'add_class:' . $helper->getButtonClasses( 'btn-success' ),
        $useIcons ? 'prepend_text:<i class="glyphicon glyphicon-refresh"></i>&nbsp;' : [],
    ],
    'tag:table'                              => 'add_class: ' . $helper->getTableClasses(),
    'tag:button&property:type,button'        => 'add_class: ' . $helper->getButtonClasses(),
    'tag:button&property:type,reset'         =>
        [
            [ 'add_class' => $helper->getButtonClasses( 'btn-warning' ) ],
            $useIcons ? [ 'prepend_text' => '<i class="glyphicon glyphicon-erase"></i>&nbsp;' ] : [],
        ],
    'template:input&dataItem:inputType,date' => [
        'js:bootstrap-datepicker',
        'css:bootstrap-datepicker',
        [
            'merge-data' => [
                [
                    'inputClass'      => 'datepicker',
                    'inputType'       => 'text',
                    'inputAttributes' => [
                        'data-provide'     => 'datepicker',
                        'data-date-format' => 'yyyy-mm-dd',
                    ],
                ],
            ],
        ],
    ],
    'template'                               => [
        [ 'override_template' => [ 'themes/twitter_bootstrap', compact( 'helper' ) ] ],
    ],
];
