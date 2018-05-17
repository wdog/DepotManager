@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
	<div class="card">
        <div class="card-header bg-dark text-white">
                <div class="pull-left">@lang('global.depots.title')</div>
	        @can('depots_manage')
		        <a href="{{ route('depots.create') }}"
		           class="pull-right btn btn-sm btn-success"
		           data-toggle="tooltip"
		           data-placement="top"
		           title="Add New Item"
		        >@lang('global.app_add_new')</a>
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
