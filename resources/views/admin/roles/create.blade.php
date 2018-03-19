@extends('layouts.app')

@section('content')
	{!! Form::open(['method' => 'POST', 'route' => ['admin.roles.store']]) !!}
	
	<div class="card">
        <div class="card-header">
            @lang('global.app_create') Roles
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-xs-4 offset-sm-4 form-group">
	                 {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
	                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
	                <p class="help-block"></p>
	                @if($errors->has('name'))
		                <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
	                @endif
                </div>
            </div>
	        <div class="row">
		        <div class="col-xs-4 offset-sm-4 form-group">
			        {!! Form::label('abilities', 'Abilities', ['class' => 'control-label']) !!}
	                {!! Form::select('abilities[]', $abilities, old('abilities'), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
	                <p class="help-block"></p>
	                @if($errors->has('abilities'))
		                <p class="help-block">
                            {{ $errors->first('abilities') }}
                        </p>
	                @endif
                </div>
            </div>
        </div>
		
		<div class="card-footer">
			{!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
		</div>
    </div>


	{!! Form::close() !!}
@stop

