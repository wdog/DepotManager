@extends('layouts.app')

@section('content')
	
	<div class="card">
        <div class="card-header bg-dark text-white">
          <div class='pull-left'>  {{ $project->name }}</div>
	        @can('projects_manage')
		        <a href="{{ route('projects.add_item',$project) }}" class="pull-right btn btn-sm btn-success">@lang('global.app_load')</a>
	        @endcan
        </div>
        <div class="card-body danger">
            {!! $grid or '' !!}
        </div>
    </div>
	
	
	@if (count($missings) > 0)
	<div class="card">
        <div class="card-header bg-dark text-white">
          <div class='pull-left'> Anomalie</div>
	        {!! Form::open(['route' => ['projects.add_missing', $project ] ]) !!}
	        <button type="submit" class="pull-right btn btn-sm btn-success">Add missing</button>
	        {!! Form::close() !!}
        </div>
	
		<div class="card-body danger">
	        <table class="table table-hover table-striped table-bordered">
	        	<thead>
	        		<tr>
	        			<th>@lang('global.code')</th>
	        			<th>@lang('global.name')</th>
	        			<th>@lang('global.qta')</th>
	        		</tr>
	        	</thead>
	        	<tbody>
	        @foreach($missings as $missing )
		        <tr>
	        			<td class='fit-cell text-right' scope="row">{{ $missing->item->code}}</td>
	        			<td>{{ $missing->item->name}}</td>
	        			<td class='fit-cell text-right'>{{ -1 * $missing->qta }}</td>
	        		</tr>
	
	
	        @endforeach
	        </tbody>
	        </table>
        </div>
    </div>
	@endif



@endsection


@section('javascript')
	<script>
		$(function () {
            $("card a").click(function (e) {
                e.stopPropagation();
            });
        })
		
	</script>
@endsection
