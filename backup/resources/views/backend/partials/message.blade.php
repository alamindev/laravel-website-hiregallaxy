{{-- Noty -> Notification Style  --}}



@if ($errors->any())

  <div class="row justify-content-center mt-4">

    <div class="col-md-12">

      <div class="alert alert-danger">

        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

        <ul>

          @foreach ($errors->all() as $error)

            <p>{{ $error }}</p>

          @endforeach

        </ul>

      </div>

    </div>

  </div>

@endif



@if (Session::has('success'))

  <script>

  new Noty({

    theme: 'sunset',

    type: 'success',

    layout: 'topCenter',

    text: "{!! Session::get('success') !!}",

    timeout: 2000

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

    timeout: 2000

  }).show();

  </script>

@endif



@if (Session::has('sticky_error'))

  <div class="row justify-content-center">

    <div class="col-md-12">

      <div class="alert alert-danger">

        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

        {!! Session::get('sticky_error') !!}

      </div>

    </div>

  </div>

@endif



@if (Session::has('sticky_success'))

  <div class="row justify-content-center">

    <div class="col-md-12">

      <div class="alert alert-success">

        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

        {!! Session::get('sticky_success') !!}

      </div>

    </div>

  </div>

@endif

@if (Session::has('message'))

  <div class="row justify-content-center">

    <div class="col-md-12">

      <div class="alert alert-info">

        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

        {!! Session::get('message') !!}

      </div>

    </div>

  </div>

@endif

