@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.items.title')</h3>
    <p>
        <a href="{{ route('items.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body">
            {!! $grid or '' !!}
        </div>
      

    </div>

@stop

@section('javascript')
    <script>
    
    </script>
@endsection
