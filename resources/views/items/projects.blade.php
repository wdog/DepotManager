@extends('layouts.app')

@section('content')
	
	
	
	<div class="card">
        <div class="card-header bg-dark text-white">
                <div class="pull-left">@lang('global.projects.title')</div>
        </div>
        <div class="card-body">
                {!! $grid or '' !!}
        </div>
		<div class="card-footer">
			{{ link_to_route('items.index', trans('global.items.title'), null,['class' => 'btn btn-info']) }}
			{{ link_to_route('projects.index', trans('global.projects.title'), null,['class' => 'btn btn-info']) }}
			
		</div>
    </div>
	
@endsection