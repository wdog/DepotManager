@extends('layouts.app')

@section('content')
	
	{!! Form::model($role, ['method' => 'PUT', 'route' => ['admin.roles.update', $role->id]]) !!}
	
	<div class="card">
        <div class="card-header bg-dark text-white">
            @lang('global.app_edit') @lang('global.roles.title')
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 offset-sm-4 form-group">
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
		        <div class="col-sm-4 offset-sm-4 form-group">
			     {!! Form::label('abilities', 'Abilities', ['class' => 'control-label']) !!}
			        {!! Form::select('abilities[]', $abilities, old('abilities') ? old('abilities') : $role->getAbilities()->pluck('name', 'name'), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
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
			{!! Form::submit(trans('global.app_update'), ['class' => 'btn  btn-sm btn-danger']) !!}
			{!! link_to_route('admin.roles.index',trans('global.app_back_to_list'),null,['class'=> 'btn btn-sm btn-info']) !!}
		</div>
    </div>
	
	
	
	{!! Form::close() !!}
@stop

