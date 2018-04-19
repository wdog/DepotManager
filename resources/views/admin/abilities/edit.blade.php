@extends('layouts.app')

@section('content')
	
	
	
	{!! Form::model($ability, ['method' => 'PUT', 'route' => ['admin.abilities.update', $ability->id]]) !!}
	
	
	<div class="card">
        <div class="card-header bg-dark text-white">
            @lang('global.app_edit') {{ trans('global.abilities.title') }}
        </div>
        
        <div class="card-body">
            <div class="row">
                 <div class="col-sm-4 offset-sm-4 form-group">
                     {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
	                 {!! Form::text('name', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
	                 <p class="help-block"></p>
	                 @if($errors->has('name'))
		                 <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
	                 @endif
                 </div>
            </div>
            
            <div class="row">
                 <div class="col-sm-4 offset-sm-4 form-group">
                     {!! Form::label('title', 'Title*', ['class' => 'control-label']) !!}
	                 {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
	                 <p class="help-block"></p>
	                 @if($errors->has('title'))
		                 <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
	                 @endif
                 </div>
            </div>
            
        </div>
        
        <div class="card-footer">
            {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-sm btn-danger']) !!}
	        {!! link_to_route('admin.abilities.index',trans('global.app_back_to_list'),null,['class'=> 'btn btn-sm btn-info']) !!}
        </div>
    </div>
	
	
	
	
	
	{!! Form::close() !!}
@stop

