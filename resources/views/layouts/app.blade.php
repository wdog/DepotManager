<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body>

@include('partials.topbar')


{{--
@if ($errors->count() > 0)
    <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
@endif
--}}




<!-- Begin page content -->
<main role="main" class="container">
    @if (Session::has('message'))
		<div class="alert alert-info">
            <p>{{ Session::get('message') }}</p>
		</div>
	@endif
	
	@if (Session::has('error'))
		<div class="alert alert-danger">
            <p>{{ Session::get('error') }}</p>
		</div>
	@endif
	
	
	@yield('content')
</main>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">Logout</button>
{!! Form::close() !!}

@include('partials.javascripts')
</body>
</html>