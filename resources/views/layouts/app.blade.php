<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body>

@include('partials.nav')
<!-- Begin page content -->
<main role="main" class="container">
	{{--messages--}}
	@if (Session::has('message'))
		<div class="alert alert-info">
            <p>{{ Session::get('message') }}</p>
		</div>
	@endif
	{{--errors--}}
	@if (Session::has('error'))
		<div class="alert alert-danger">
            <p>{{ Session::get('error') }}</p>
		</div>
	@endif
	{{--main content--}}
	@yield('content')
</main>
{{--hidden--}}
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit"></button>
{!! Form::close() !!}

@include('partials.javascripts')
</body>
</html>