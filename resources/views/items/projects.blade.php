@extends('layouts.app')

@section('content')
	
	
	
	<div class="card">
        <div class="card-header bg-dark text-white">
                <div class="pull-left">@lang('global.projects.title')</div>
        </div>
        <div class="card-body">
                {!! $grid or '' !!}
        </div>
    </div>
	
@endsection