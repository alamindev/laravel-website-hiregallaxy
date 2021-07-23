<!DOCTYPE html>

<html lang="en">



<head>



  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="description" content="">

  <meta name="author" content="">



  <title>@yield('title', 'Admin Panel | Joblrs')</title>



  @include('backend.partials.styles')

  @yield('stylesheets')



</head>



<body id="page-top">

 <div class="container">



    @yield('content')



  </div>







  @include('backend.partials.scripts')

  @yield('scripts')



</body>



</html>

