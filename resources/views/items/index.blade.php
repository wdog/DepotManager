@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.items.title')</h3>
    <p>
        <a href="{{ route('items.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($items) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all"/></th>
                        <th>@lang('global.items.fields.code')</th>
                        <th>@lang('global.items.fields.name')</th>
                        <th>@lang('global.items.fields.um')</th>
                        <th>@lang('global.items.fields.disabled')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($items) > 0)
                        @foreach ($items as $item)
                            <tr data-entry-id="{{ $item->id }}">
                                <td></td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name}}</td>
                                <td>{{ $item->um}}</td>
                                <td>{{ $item->disabled}}</td>
                                <td>
                                    @can('items_manage')
                                        <a href="{{ route('items.edit',[$item->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'DELETE',
                                            'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                            'route' => ['items.destroy', $item->id])) !!}
                                        {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                    <a href="{{ route('items.show',[$item->id]) }}" class="btn btn-xs btn-success">@lang('global.app_view')</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
    
    </script>
@endsection
