@extends('layouts.app')

@section('content')
	
	{!! Form::open(['method' => 'POST', 'route' => ['depots.movement_item', $depot, $item->pivot->id ]]) !!}
	
	<div class="card">
		<div class="card-header">
			Unload Depot: {{ $depot->name }}<br>
		</div>
		
		
		
		
		<div class="card-body">

			{{-- INFO --}}
			<div class="container-fluid ">
				<div class="row alert-info alert">
					<div class="col-md-3">
					<strong>Name: </strong> {{ $item->name }}
					</div>
					<div class="col-md-3">
					<strong>Code: </strong> {{ $item->code }}
					</div>
					<div class="col-md-3">
					<strong>Serial: </strong>{{ $item->serial }}
					</div>
					<div class="col-md-3">
					<strong>Qta: </strong>{{ $item->pivot->qta_depot }}  {{ $item->um }}
					</div>
				</div>
			</div>
			{{-- REASON --}}
			<div class="row">
                <div class="col-xs-4 offset-sm-4 form-group">
                    {!! Form::label('reason', 'Cause*', ['class' => 'control-label']) !!}
	                {!! Form::select('reason', \App\Utils\Helpers::ComboReasons(), old('reason'), ['class' => 'form-control select2 ', 'placeholder' => '', 'required' => '']) !!}
	
	                <p class="help-block"></p>
	                @if($errors->has('reason'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('reason') }}
                        </p>
	                @endif
                </div>
            </div>
			{{-- QTA --}}
			<div class="row">
                <div class="col-xs-4 offset-sm-4 form-group">
                    {!! Form::label('qta', 'Qta*', ['class' => 'control-label']) !!}
	                {!! Form::number('qta', old('qta'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
	                <p class="help-block"></p>
	                @if($errors->has('qta'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('qta') }}
                        </p>
	                @endif
                </div>
            </div>

			 
			

		</div>
		
		<div class="card-footer">
			  {!! Form::submit(trans('global.app_unload'), ['class' => 'btn btn-danger']) !!}
		</div>
		
	</div>
	
	
	{!! Form::close() !!}

@endsection
