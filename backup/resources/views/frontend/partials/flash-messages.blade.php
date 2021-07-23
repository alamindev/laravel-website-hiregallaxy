@if (Session::has('message'))
  <script>
  new Noty({
    theme: 'sunset',
    type: 'warning',
    layout: 'topCenter',
    text: "{!! Session::get('message') !!}",
    timeout: 6000
  }).show();
  </script>
@endif


@if (Session::has('success'))
  <script>
  new Noty({
    theme: 'sunset',
    type: 'success',
    layout: 'topCenter',
    text: "{!! Session::get('success') !!}",
    timeout: 3000
  }).show();
  </script>
@endif

@if (Session::has('error'))
  <script>
  new Noty({
    theme: 'sunset',
    type: 'error',
    layout: 'topCenter',
    text: "{!! Session::get('error') !!}",
    timeout: 3000
  }).show();
  </script>
@endif