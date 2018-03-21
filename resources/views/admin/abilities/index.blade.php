@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header bg-dark text-white">
                <div class="pull-left">{{ trans('global.abilities.title') }}</div>
            @can('users_manage')
                <a href="{{ route('admin.abilities.create') }}" class="pull-right btn btn-sm btn-success">@lang('global.app_add_new')</a>
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