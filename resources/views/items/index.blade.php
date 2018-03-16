@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
                <h4 class="pull-left">Items</h4>
                <a href="{{ route('items.create') }}" class="pull-right btn btn-sm btn-success">@lang('global.app_add_new')</a>
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
