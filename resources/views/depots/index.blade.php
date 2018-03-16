@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
	<div class="card card-default">
        <div class="card-header">
                <h4 class="pull-left">Depots</h4>
	        @can('depots_manage')
		        <a href="{{ route('depots.create') }}" class="pull-right btn btn-sm btn-success">@lang('global.app_add_new')</a>
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
