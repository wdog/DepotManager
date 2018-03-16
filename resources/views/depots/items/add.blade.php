@extends('layouts.app')

@section('content')
	
	{!! Form::open(['method' => 'POST', 'route' => ['depots.store_item', $depot ]]) !!}
	
	<div class="card">
		<div class="card-header">
			Load Depot: {{ $depot->name }}
		</div>
		
		<div class="card-body">
		
			   <div class="row">
                <div class="col-xs-4 offset-sm-4 form-group">
                    {!! Form::label('item_id', 'Item*', ['class' => 'control-label']) !!}
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
                <div class="col-xs-4 offset-sm-4 form-group">
                    {!! Form::label('qta_ini', 'Qta*', ['class' => 'control-label']) !!}
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
                <div class="col-xs-4 offset-sm-4 form-group">
                    {!! Form::label('serial', 'Serial*', ['class' => 'control-label']) !!}
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
		  {!! Form::submit(trans('global.app_load'), ['class' => 'btn btn-danger']) !!}
	
		</div>
	</div>
	{!! Form::close() !!}

@endsection

@section('javascript')
	<script>
		/*
		 $(function () {
		 $("select[name=item_id]").on("select2:selecting", function (e) {
		 var value = $(e.currentTarget).find("option:selected").val();
		 console.log(value);
		 });
		 });
		 */
	</script>
@endsection