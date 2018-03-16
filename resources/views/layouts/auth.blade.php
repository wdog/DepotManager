<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')


<style>
    body {
        /* The image used */
        background-image: url("/img/depot-bg.jpg") !important;
    
        /* Full height */
        height: 100%;
    
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
</head>
<body>

    <div style="margin-top: 10%;"></div>
    
    <div class="container-fluid">
        <div class="row">
            @yield('content')
            
            
        </div>
    </div>
    

</body>
</html>