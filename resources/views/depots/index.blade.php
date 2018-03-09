@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.depots.title')</h3>
    <p>
        <a href="{{ route('depots.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($depots) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all"/></th>

                        <th>@lang('global.depots.fields.depot_name')</th>
                        <th>@lang('global.depots.fields.group')</th>
                        <th>&nbsp;</th>

                    </tr>
                </thead>
                
                <tbody>
                    @if (count($depots) > 0)
                        @foreach ($depots as $depot)
                            <tr data-entry-id="{{ $depot->id }}">
                                <td></td>

                                <td>{{ $depot->name }}</td>
                                <td>{{ $depot->group->name }}</td>
                                <td>
                                    @can('depots_manage')
                                    <a href="{{ route('depots.edit',[$depot->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['depots.destroy', $depot->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                    <a href="{{ route('depots.show',[$depot->id]) }}" class="btn btn-xs btn-success">@lang('global.app_view')</a>
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">@lang('global.app_no_entries_in_table')</td>
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
