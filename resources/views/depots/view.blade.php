@extends('layouts.app')

@section('content')
    
    <div class="card">
     <div class="card-header">{{ $depot->name }}</div>
   <div class="card-body">
      {{ $grid or '' }}
   </div>
 </div>

@endsection