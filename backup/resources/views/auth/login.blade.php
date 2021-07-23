<html>

<head>

    <title>

        Login | Joblrs

    </title>

    @include('frontend.partials.styles')

</head>

<body>

    <!-- Header -->

    <div class="header-main">



        <!-- Top Header -->

        @include('frontend.partials.top-header')

        <!-- Top Header -->



        <!-- Navbar -->

        @include('frontend.partials.nav')

        <!-- Navbar -->



    </div>

    <!-- Header -->

    @include('frontend.partials.messages')

    @include('frontend.partials.signin-modal')

</body>



@include('frontend.partials.scripts')

</html>