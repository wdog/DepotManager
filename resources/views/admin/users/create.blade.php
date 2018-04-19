@extends('layouts.app')

@section('content')
	
	{!! Form::open(['method' => 'POST', 'route' => ['admin.users.store']]) !!}
	
	<div class="card">
        <div class="card-header bg-dark text-white">
            @lang('global.app_create') @lang('global.users.title')
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
                    {!! Form::label('email', 'Email*', ['class' => 'control-label']) !!}
			        {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
			        <p class="help-block"></p>
			        @if($errors->has('email'))
				        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
			        @endif
		        </div>
            </div>
	        <div class="row">
		        <div class="col-sm-4 offset-sm-4 form-group">
                    {!! Form::label('password', 'Password*', ['class' => 'control-label']) !!}
			        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
			        <p class="help-block"></p>
			        @if($errors->has('password'))
				        <p class="help-block">
                            {{ $errors->first('password') }}
                        </p>
			        @endif
		        </div>
	        </div>
	        <div class="row">
		        <div class="col-sm-4 offset-sm-4 form-group">
                    {!! Form::label('roles', 'Roles*', ['class' => 'control-label']) !!}
			        {!! Form::select('roles[]', $roles, old('roles'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}
			        <p class="help-block"></p>
			        @if($errors->has('roles'))
				        <p class="help-block">
                            {{ $errors->first('roles') }}
                        </p>
			        @endif
                </div>
            </div>
	        <div class="row">
		        <div class="col-sm-4 offset-sm-4 form-group">
                    {!! Form::label('group_id', 'Group*', ['class' => 'control-label']) !!}
			        {!! Form::select('group_id', $groups, old('group_id') , ['class' => 'form-control select2', 'placeholder' => '',  'required' => '']) !!}
			        <p class="help-block"></p>
			        @if($errors->has('group_id'))
				        <p class="help-block">
                            {{ $errors->first('group_id') }}
                        </p>
			        @endif
		        </div>
            </div>
        </div>
		<div class="card-footer">
			{!! Form::submit(trans('global.app_save'), ['class' => 'btn  btn-sm btn-danger']) !!}
			{!! link_to_route('admin.users.index',trans('global.app_back_to_list'),null,['class'=> 'btn btn-sm btn-info']) !!}
		</div>
	</div>
	
	{!! Form::close() !!}
@stop

