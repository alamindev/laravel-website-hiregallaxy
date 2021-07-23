<!-- dropify -->

<link href="{{ asset('js/dropify/dropify.css') }}" rel="stylesheet">


<!-- Parsley -->
<link rel="stylesheet" href="{{ asset('css/parsley/parsley.css') }}">
<!-- noty -->

<link href="{{ asset('css/noty/noty.css') }}" rel="stylesheet">



<!-- Noty -->

<script src="{{ asset('/js/noty/noty.min.js') }}"></script>





<!-- dataTable -->

<link href="{{ asset('admin-asset/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">



<!-- Custom fonts for this template-->

<link href="{{ asset('admin-asset/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

<link

  href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"

  rel="stylesheet">



<!-- Custom styles for this template-->

<link href="{{ asset('admin-asset/css/sb-admin-2.min.css') }}" rel="stylesheet">

<link href="{{ asset('admin-asset/vendor/select2/css/select2.min.css') }}" rel="stylesheet">

<!-- Custom styles-->

<link href="{{ asset('admin-asset/css/custom.css') }}?v={{ config('constants.asset_version') }}"

  rel="stylesheet">

<link rel="shortcut icon" href="{{ asset('images/'.App\Models\Setting::first()->site_favicon) }}"

  type="image/x-icon">



@include('backend.partials.admin_themes')
