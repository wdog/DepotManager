@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.items.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['items.store']]) !!}
    
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_create')
        </div>
        
        <div class="panel-body">
            
             <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('code', 'Item Code*', ['class' => 'control-label']) !!}
                    {!! Form::text('code', old('code'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('code'))
                        <p class="help-block">
                            {{ $errors->first('code') }}
                        </p>
                    @endif
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', 'Item Name*', ['class' => 'control-label']) !!}
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
                <div class="col-xs-12 form-group">
                    {!! Form::label('um', 'Unit*', ['class' => 'control-label']) !!}
                    {!! Form::select('um', \App\Utils\Helpers::ComboUnita(), old('um'), ['class' => 'select2 form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('um'))
                        <p class="help-block">
                            {{ $errors->first('um') }}
                        </p>
                    @endif
                </div>
            </div>
            
            
        </div>
    </div>
    
    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

