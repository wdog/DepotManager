@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
                <h4 class="pull-left">Users</h4>
            @can('users_manage')
                <a href="{{ route('admin.users.create') }}" class="pull-right btn btn-sm btn-success">@lang('global.app_add_new')</a>
            @endcan
        </div>

        <div class="card-body">
            {!! $grid or '' !!}
        </div>
    </div>
@stop

@section('javascript') 
    <script>
    </script>
@endsection
