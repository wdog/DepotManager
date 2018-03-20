@extends('layouts.app')

@section('content')
	
	{!! Form::open(['method' => 'POST', 'route' => ['depots.movement_item', $depot, $item->pivot->id ]]) !!}
	
	<div class="row">
		<div class="col-sm-6">
		    <div class="card">
				<div class="card-header">
					Depot: <strong>{{ $depot->name }}</strong>
				</div>
			    <div class="card-body">
				    <div class="card-text">
					{{-- REASON --}}
					    <div class="form-group">
				            {!! Form::label('reason', 'Cause*', ['class' => 'control-label']) !!}
						    {!! Form::select('reason', \App\Utils\Helpers::ComboReasons(), old('reason'), ['class' => 'form-control select2 ', 'placeholder' => '', 'required' => '']) !!}
						    @if($errors->has('reason'))
							    <p class="help-block alert alert-danger">{{ $errors->first('reason') }}</p>
						    @endif
					</div>
					    {{-- QTA --}}
					    <div class="form-group">
						{!! Form::label('qta', 'Qta*', ['class' => 'control-label']) !!}
						    {!! Form::number('qta', old('qta'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
						    @if($errors->has('qta'))
							    <p class="help-block alert alert-danger">{{ $errors->first('qta') }}</p>
						    @endif
			        </div>
					
					    {{-- DEPOTS --}}
					    @can('depots_manage')
						    <div class="form-group">
								{!! Form::label('depot_id', 'Depot', ['class' => 'control-label']) !!}
							    {!! Form::select('depot_id', $depots, old('depot_id'), ['class' => 'form-control select2 ', 'placeholder' => '-']) !!}
							    @if($errors->has('depot_id'))
								    <p class="help-block alert alert-danger">{{ $errors->first('depot_id') }}</p>
							    @endif
							</div>
					    @endcan
				</div>
				   
			    </div>
			    <div class="card-footer">
			        {!! Form::submit(trans('global.app_unload'), ['class' => 'btn btn-danger']) !!}
				</div>
		    </div>
		</div>
		<div class="col-sm-6">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">{{ $item->name }}</h4>
					<div class="card-text">
					{{-- INFO --}}
						<ul class="list-group ">
							<li class="list-group-item list-group-item-info "><strong>Code: </strong> {{ $item->code }}</li>
							<li class="list-group-item list-group-item-info"><strong>Serial: </strong>{{ $item->serial }}</li>
							<li class="list-group-item list-group-item-info"><strong>Qta: </strong>{{ $item->pivot->qta_depot }}  {{ $item->um }}</li>
						</ul>
					</div>
	            </div>
			</div>
		</div>
	 
	</div>
	
	{!! Form::close() !!}

@endsection
