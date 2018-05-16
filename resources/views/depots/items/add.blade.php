@extends('layouts.app')

@section('content')
	
	{!! Form::open(['method' => 'POST', 'route' => ['depots.store_item', $depot ]]) !!}
	
	<div class="card">
		<div class="card-header bg-dark text-white">
			Load Depot: {{ $depot->name }}
		</div>
		
		<div class="card-body">
		
			   <div class="row">
                <div class="col-md-4 offset-md-4 form-group">
                    {!! Form::label('item_id', trans('global.items.title'). '*', ['class' => 'control-label']) !!}
	                {!! Form::select('item_id', $items, old('item_id'), ['class' => 'select2 form-select', 'placeholder' => '', 'required' => '']) !!}
	                <p class="help-block"></p>
	                @if($errors->has('item_id'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('item_id') }}
                        </p>
	                @endif
                </div>
            </div>
			
			<div class="row">
                <div class="col-md-4 offset-md-4 form-group">
                    {!! Form::label('qta_ini', trans('global.qta'). '*', ['class' => 'control-label']) !!}
	                {!! Form::number('qta_ini', old('qta_ini'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
	                <p class="help-block"></p>
	                @if($errors->has('qta_ini'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('qta_ini') }}
                        </p>
	                @endif
                </div>
            </div>
			
			
				<div class="row">
                <div class="col-md-4 offset-md-4 form-group">
                    {!! Form::label('serial', trans('global.serial') .'*', ['class' => 'control-label']) !!}
	                {!! Form::text('serial', old('serial'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
	                <p class="help-block">@lang('global.app_help_empty')</p>
	                @if($errors->has('serial'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('serial') }}
                        </p>
	                @endif
                </div>
            </div>
		</div>
	
		<div class="card-footer text-muted">
			{!! Form::submit(trans('global.app_load'), ['class' => 'btn btn-sm btn-danger submit']) !!}
			{!! link_to_route('depots.show',trans('global.app_back_to_list'),$depot,['class'=> 'btn btn-sm btn-info ']) !!}
		</div>
	</div>
	{!! Form::close() !!}

@endsection

@section('javascript')
	<script>


     $("form").submit(function () {
         $(this).submit(function () {
             return false;
         });
         return true;
     });
		
	</script>
@endsection