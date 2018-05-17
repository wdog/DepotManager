@extends('layouts.app')

@section('content')
	<h4 class="text-center elegantshd">@lang('global.depots.title')</h4>
	<div class="row">
		@foreach($depots as $depot)
			<div class="col-sm-2 p-1">
				<div class="card" style='min-height: 200px'>
					@if ( $depot->group->slug != 'admin')
						<img class="card-img-top img-fluid" src="/img/warehouse.jpg" alt="depot {{ $depot->name }}">
					@else
						<img class="card-img-top img-fluid" src="/img/warehouse_admin.jpg" alt="depot {{ $depot->name }}">
					@endif
					<div class="card-body" style="position: relative; ">
							<div class="card-title" >
								<a href="{{ route('depots.show', $depot) }}" class="dashboard d-block">
									<h5>
										{{ $depot->name }}
										<i class="fa fa-sign-in" aria-hidden="true"></i>
									</h5>
									<p class="card-text"> {{ $depot->group->name }}</p>
								</a>
							</div>
							
						</div>
				</div>
			</div>
		@endforeach
	</div>
	
	<h4 class="text-center elegantshd">@lang('global.projects.title')</h4>
	<div class="row">
			@foreach($projects as $project)
			<div class="col-sm-2 p-1">
				<div class="card">
					<img src="/img/projects.jpg" class="card-img-top img-fluid">
					<div class="card-body">
						@can('projects_manage')
							<a href="{{ route('projects.show',$project) }}" class='dashboard'>
						@endcan
								<h5 class="text-center">{{ $project->name }}</h5>
								@can('projects_manage')
							</a>
						@endcan
					</div>
				</div>
			</div>
		@endforeach
	
	</div>
	
	<style>
		.card {
			box-shadow    : 0 4px 8px 0 rgba(0, 0, 0, 0.2) !important;
			transition    : 0.3s;
			border-radius : 5px;
			
		}
		
		.card img {
			border-radius : 5px 5px 0 0;
		}
		
		.card:hover {
			box-shadow : 0 8px 16px 0 rgba(0, 0, 0, 0.2) !important;
		}

	</style>

@endsection
