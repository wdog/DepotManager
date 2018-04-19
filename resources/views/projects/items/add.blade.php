@extends('layouts.app')

@section('content')
	
	
	{!! Form::open(['method' => 'POST', 'route' => ['projects.store_item', $project ]]) !!}
	
	<div class="card">
		<div class="card-header bg-dark text-white">
			Load Depot: {{ $project->name }}
		</div>
		
		<div class="card-body">
		
			   <div class="row">
                <div class="col-md-6 offset-md-3 form-group">
                    {!! Form::label('item_id', trans('global.items.title'). '*', ['class' => 'control-label']) !!}
	                {!! Form::select('item_id', $items, old('item_id'), ['class' => 'select2 form-control', 'placeholder' => '', 'required' => '']) !!}
	                <p class="help-block"></p>
	                @if($errors->has('item_id'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('item_id') }}
                        </p>
	                @endif
                </div>
            </div>
			
			<div class="row">
                <div class="col-md-6 offset-md-3 form-group">
                    {!! Form::label('qta_req', trans('global.qta'). '*', ['class' => 'control-label']) !!}
	                {!! Form::number('qta_req', old('qta_req'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
	                <p class="help-block"></p>
	                @if($errors->has('qta_req'))
		                <p class="help-block alert alert-danger">
                            {{ $errors->first('qta_req') }}
                        </p>
	                @endif
                </div>
            </div>
			
		</div>
	
		<div class="card-footer text-muted">
			{!! Form::submit(trans('global.app_load'), ['class' => 'btn btn-sm btn-danger']) !!}
			{!! link_to_route('projects.show',trans('global.app_back_to_list'),$project,['class'=> 'btn btn-sm btn-info']) !!}
		</div>
	</div>
	{!! Form::close() !!}

@endsection

@section('javascript')
	<script>

	</script>
@endsection