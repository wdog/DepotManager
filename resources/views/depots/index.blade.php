@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
                <h3 class="pull-left">Depots</h3>
                <a href="{{ route('depots.create') }}" class="pull-right btn btn-sm btn-success">@lang('global.app_add_new')</a>
        </div>

        <div class="card-body">
            {!! $grid or '' !!}
        </div>
    </div>
@stop

@section('javascript')
    <script>
    
    </script>
@endsection
