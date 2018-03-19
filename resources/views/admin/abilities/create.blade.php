@extends('layouts.app')

@section('content')

	{!! Form::open(['method' => 'POST', 'route' => ['admin.abilities.store']]) !!}
	
	<div class="card">
        <div class="card-header">
            @lang('global.app_create') Abilities
        </div>
        <div class="card-body">
	        <div class="row">
		        <div class="col-xs-4 offset-sm-4 form-group">
                   {!! Form::label('name', 'Depot Name*', ['class' => 'control-label']) !!}
			        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
			        <p class="help-block"></p>
			        @if($errors->has('name'))
				        <p class="help-block alert alert-danger">
                            {{ $errors->first('name') }}
                        </p>
			        @endif
		        </div>
	        </div>
         
         
			<div class="row">
				<div class="col-xs-4 offset-sm-4 form-group">
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
			{!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
		</div>
    </div>
	
	{!! Form::close() !!}
@stop

