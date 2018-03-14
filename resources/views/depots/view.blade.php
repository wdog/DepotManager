@extends('layouts.app')

@section('content')
    
    <div class="card">
        <div class="card-header">
          <h3 class='pull-left'>  {{ $depot->name }}</h3>
            <a href="{{ route('depots.add_item',$depot) }}" class="pull-right btn btn-sm btn-success">@lang('global.app_load')</a>
        </div>
        <div class="card-body">
            {!! $grid or '' !!}
        </div>
 </div>

@endsection