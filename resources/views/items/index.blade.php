@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
	<div class="card">
        <div class="card-header bg-dark text-white">
                <div class="pull-left">@lang('global.items.title')</div>
                <a href="{{ route('items.create') }}" class="pull-right btn btn-sm btn-success">@lang('global.app_add_new')</a>
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
