@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.depots.title')</h3>
    {!! Form::model($depot, ['method' => 'PUT', 'route' => ['depots.update', $depot->id]]) !!}
    
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', 'Depot Name*', ['class' => 'control-label']) !!}
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
    </div>
    
    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

