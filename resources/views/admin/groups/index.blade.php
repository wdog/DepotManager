@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.groups.title')</h3>
    <p>
        <a href="{{ route('admin.groups.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($groups) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all"/></th>

                        <th>@lang('global.groups.fields.group_name')</th>
                        <th>@lang('global.groups.fields.slug')</th>
                        <th>@lang('global.groups.fields.users')</th>
                        <th>&nbsp;</th>

                    </tr>
                </thead>
                
                <tbody>
                    @if (count($groups) > 0)
                        @foreach ($groups as $group)
                            <tr data-entry-id="{{ $group->id }}">
                                <td></td>

                                <td>{{ $group->group_name }}</td>
                                <td>{{ $group->slug }}</td>
                                <td>
                                    @foreach ($group->users as $user)
                                        <span class="label label-info label-many">{{ $user->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.groups.edit',[$group->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.groups.destroy', $user->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('global.app_no_entries_in_table')</td>
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
