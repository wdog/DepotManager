@extends('layouts.app')

@section('content')
    
    {!! Form::open(['method' => 'POST', 'route' => ['depots.store']]) !!}

    <div class="card">
        <div class="card-header">
            @lang('global.app_create') Depot
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
                    {!! Form::label('group_id', 'Group*', ['class' => 'control-label']) !!}
                    {!! Form::select('group_id', $groups, old('group_id') , ['class' => 'form-control select2', 'placeholder' => '',  'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('group_id'))
                        <p class="help-block alert alert-danger">
                            {{ $errors->first('group_id') }}
                        </p>
                    @endif
                </div>
            </div>
            
            
        </div>
        
          <div class="card-footer">
              {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
              {!! Form::close() !!}
          </div>
    </div>
    
    
@stop

