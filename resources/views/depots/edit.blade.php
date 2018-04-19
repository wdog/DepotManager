@extends('layouts.app')

@section('content')
	
	{!! Form::model($depot, ['method' => 'PUT', 'route' => ['depots.update', $depot->id]]) !!}
	
	<div class="card">
        <div class="card-header bg-dark text-white">
            @lang('global.app_edit') {{trans('global.depots.title')}}
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 offset-sm-4 form-group">
                    {!! Form::label('name',trans('global.depots.title'). '*', ['class' => 'control-label']) !!}
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
                    {!! Form::label('group_id', trans('global.groups.title').'*', ['class' => 'control-label']) !!}
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
            {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-sm btn-danger']) !!}
	        {!! link_to_route('depots.index',trans('global.app_back_to_list'),null,['class'=> 'btn btn-sm btn-info']) !!}
        </div>
        
    </div>
	{!! Form::close() !!}

@stop

