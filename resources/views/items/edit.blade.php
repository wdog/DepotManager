@extends('layouts.app')

@section('content')
	
	{!! Form::model($item, ['method' => 'PUT', 'route' => ['items.update', $item->id], 'files'=> true]) !!}
	
	<div class="card">
        <div class="card-header bg-dark text-white">
            @lang('global.app_edit') @lang('global.items.title')
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 offset-sm-4 form-group">
                    {!! Form::label('code', trans('global.code').' (*)', ['class' => 'control-label']) !!}
	                {!! Form::text('code', old('code'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
	                <p class="help-block"></p>
	                @if($errors->has('code'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('code') }}
                        </p>
	                @endif
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4 offset-sm-4 form-group">
                    {!! Form::label('name', trans('global.name').' (*)', ['class' => 'control-label']) !!}
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
                <div class="col-sm-4 offset-sm-4 form-group">
                    {!! Form::label('um', trans('global.unit').' (*)', ['class' => 'control-label']) !!}
	                {!! Form::select('um', \App\Utils\Helpers::ComboUnita(), old('um'), ['class' => 'select2 form-control', 'placeholder' => '', 'required' => '']) !!}
	                <p class="help-block"></p>
	                @if($errors->has('um'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('um') }}
                        </p>
	                @endif
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4 offset-sm-4 form-group">
                {!! Form::label('disabled', trans('global.disabled').' (*)', ['class' => 'control-label']) !!}
	                {!! Form::checkbox('disabled', 1 , old('disabled'),  ['class' => 'form-check']) !!}
	                <p class="help-block"></p>
	                @if($errors->has('disabled'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('disabled') }}
                        </p>
	                @endif
                </div>
            </div>
         
	        
	         <div class="row">
                <div class="col-sm-4 offset-sm-4 form-group">
                    {!! Form::label('item_image', trans('global.image'), ['class' => 'control-label']) !!}
	                {!! Form::file('item_image',  null , ['class' => 'form-control', ]) !!}
	                <p class="help-block">
		                <div class="card" style="width: 10rem;">
                            <img class="card-img-top rounded" src="{{$item->item_image->small->url}}" alt="Card image cap">
						</div>
	                </p>
	                @if($errors->has('item_image'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('item_image') }}
                        </p>
	                @endif
                </div>
            </div>
	
	
	</div>
	
	<div class="card-footer">
            {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-sm btn-danger']) !!}
		{!! link_to_route('items.index',trans('global.app_back_to_list'),null,['class'=> 'btn btn-sm btn-info']) !!}
        </div>
	</div>
	{!! Form::close() !!}

@stop

